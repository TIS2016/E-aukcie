<?php

namespace Model;


use DataObject\AdminFromData;
use Validator\ClientInputValidator;

class FormModel extends AbstractModel
{
    public function getFormData($urlParts)
    {
        if (isset($urlParts[FIRST_URL_INDEX + 1])) {
            return $this->getAdminData($urlParts[FIRST_URL_INDEX + 1]);
        }
        return new AdminFromData();
    }

    /**
     * @param $data array
     * @param $file
     * @return  $id int
     * @throws ModelException
     * @internal param $files $_FILES
     */
    public function saveAdminData($data, $file)
    {
        $dataObject = $this->saveToDataToObject($data);

        $preparedData = $dataObject->getDataArray();

        $id = $this->query('SELECT max(id) FROM auction', array())[0]['max'] + 1;
        $sql = '
            INSERT INTO auction (id, fk_auction_status, fk_auction_type, fk_currency, fk_project, name, description)
            VALUES (:id, :status, :type, :currency, :projectId, :name, :description);
        ';
        if($file['document']['name'] == ''){
            throw new ModelException("Nemáte vybraný žiadný súbor");
        }
        $this->saveFile($id, $file['document'], 'admin');

        $this->query($sql, array(
                ':id' => $id,
                ':status' => $dataObject->getStatus(),
                ':type' => $dataObject->getType(),
                ':currency' => $dataObject->getCurrency(),
                ':projectId' => $dataObject->getProject(),
                ':name' => $dataObject->getNazov(),
                ':description' => json_encode($preparedData))
        );
        $this->addAuctionUser($id, 'ADMIN');


//        if ($files['documents']) {
//            $file_ary = $this->reArrayFiles($files['documents']);
//
//            foreach ($file_ary as $file) {
//                $this->saveFile($id, $file, 'admin');
////                print 'File Name: ' . $file['name'];
////                print 'File Type: ' . $file['type'];
////                print 'File Size: ' . $file['size'];
//            }
//        }

        return $id;
    }

    public function saveClientData($data, $file, $auctionId)
    {
        if (!isset($data['company_name']) || !isset($data['contact_person']) || !isset($data['telephone']) ||
            !isset($data['email']) || !isset($data['ico']) || !isset($data['dic']) || !isset($data['address'])
        ) {
            throw new ModelException("Missing data");
        }
        if (!ClientInputValidator::isValidName($data['contact_person'])) {
            throw new ModelException("Zle zadaná kontaktná osoba");
        }
        if (!ClientInputValidator::isValidTel($data['telephone'])) {
            throw new ModelException("Zle zadané telefónne číslo");
        }
        if (!ClientInputValidator::isValidIco($data['ico'])) {
            throw new ModelException("Zle zadané ičo");
        }
        if (!ClientInputValidator::isValidDic($data['dic'])) {
            throw new ModelException("Zle zadané dič");
        }
        $this->saveFile($auctionId, $file['document'], 'user', $_SESSION['name']);

        $id = $this->query('SELECT max(id) FROM client', array())[0]['max'] + 1;
        $sql = '
            INSERT INTO client(id, company_name, ico, dic, address, contact_person, telephone, email)
            VALUES (:id, :company_name, :ico, :dic, :address, :contact_person, :telephone, :email)';
        $this->query($sql, array(
                ':id' => $id,
                ':company_name' => $data['company_name'],
                ':contact_person' => $data['contact_person'],
                ':telephone' => $data['telephone'],
                ':email' => $data['email'],
                ':ico' => $data['ico'],
                ':dic' => $data['dic'],
                ':address' => $data['address']
            )
        );
        $this->addAuctionUser($auctionId, 'PARTICIPANT');
    }

    public function getadminDataFromPost($post)
    {
        return $this->saveToDataToObject($post);
    }

    /**
     * @param $id string
     * @return AdminFromData
     * @throws ModelException
     */
    private function getAdminData($id)
    {
        $sql = '
            SELECT
                description
            FROM auction
            WHERE id=:id
        ';

        $result = $this->query($sql, array('id' => $id));
        if (!count($result)) {
            throw new ModelException('Auction not fond!');
        }
        return $this->saveToDataToObject(json_decode($result[0]['description'], true));
    }

    /**
     * @param $data array
     * @return AdminFromData
     */
    private function saveToDataToObject($data)
    {
        $dataObject = new AdminFromData();

        $dataObject->setProject(intval($data['projectId']));
        $dataObject->setCurrency($data['auctionCurrency']);
        $dataObject->setStatus($data['auctionStatus']);
        $dataObject->setType($data['auctionType']);
        $dataObject->setNazov($data['nazov']);
        $dataObject->setVyhlasovatel($data['vyhlasovatel']);
        $dataObject->setPrevadzkovatel($data['prevadzkovatel']);
        $dataObject->setPredmet($data['predmet']);
        $dataObject->setPozadovanePodklady($data['pozadovanePodklady']);
        $dataObject->setKriteria($data['kriteria']);
        $dataObject->setTerminDorucenia($data['temrinDorucenia']);
        $dataObject->setTerminOdovzdania($data['terminOdovzdania']);
        $dataObject->setTerminAukcie($data['terminAukcie']);

        return $dataObject;
    }

    private function addAuctionUser($id, $role)
    {
        $sql = '
            INSERT INTO auction_user (fk_auction, fk_user, fk_auction_role, user_coeficient, active_in_auction, alias)
            VALUES (:id, :user, :role, 1, TRUE, :alias)
        ';
        $this->query($sql, array(
            ':id' => $id,
            ':user' => $_SESSION['login'],
            ':role' => $role,
            ':alias' => $_SESSION['name']
        ));
    }

    private function saveFile($id, $file, $role, $uname = '')
    {
//        print_r($file);
        if ($file['error'] != 0) return;
        $fileName = $file['name'];
        $pathInfo = pathinfo($file['name']);
        $tmpName = $file['tmp_name'];
        $extension = $pathInfo['extension'];

        $allowedExtensions = array('pdf', 'zip', 'doc', 'docx', 'xls', 'xlsx');
        if (is_uploaded_file($tmpName)) {
            if (!in_array($extension, $allowedExtensions)) {
                throw new ModelException("Wrong file format!");
            }
            if ($role == 'admin') {
                $dirName = PROJECT_ROOT . '\\auction_files\\' . $id . '\\admin';
                mkdir($dirName, 0777, true);
                mkdir(PROJECT_ROOT . '\\auction_files\\' . $id . '\\userFiles', 0777);
                move_uploaded_file($tmpName, $dirName . '\\' . $fileName);
                chmod($dirName . '\\' . $fileName, 777);
            }
            if ($role == 'user') {
                $dirName = PROJECT_ROOT . '\\auction_files\\' . $id . '\\userFiles';
                move_uploaded_file($tmpName, $dirName . '\\' . $uname . '.' . $extension);
            }
        }
//        echo($file['tmp_name']);
    }

//    private function reArrayFiles(&$file_post)
//    {
//
//        $file_ary = array();
//        $file_count = count($file_post['name']);
//        $file_keys = array_keys($file_post);
//
//        for ($i = 0; $i < $file_count; $i++) {
//            foreach ($file_keys as $key) {
//                $file_ary[$i][$key] = $file_post[$key][$i];
//            }
//        }
//
//        return $file_ary;
//    }
}