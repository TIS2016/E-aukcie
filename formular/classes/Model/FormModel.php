<?php

namespace Model;


use DataObject\AdminFromData;

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
     */
    public function saveAdminData($data)
    {
        $dataObject = $this->saveToDataToObject($data);

        $preparedData = $dataObject->getDataArray();

        $id = $this->query('SELECT max(id) FROM auction', array())[0]['max'] + 1;
        $sql = '
            INSERT INTO auction (id, fk_auction_status, fk_auction_type, fk_currency, fk_project, name, description)
            VALUES (:id, :status, :type, :currency, :projectId, :name, :description);
        ';
        $this->query($sql, array(
                ':id' => $id,
                ':status' => $dataObject->getStatus(),
                ':type' => $dataObject->getType(),
                ':currency' => $dataObject->getCurrency(),
                ':projectId' => $dataObject->getProject(),
                ':name' => $dataObject->getNazov(),
                ':description' => json_encode($preparedData))
        );
        return $id;
    }

    public function saveClientData($data)
    {
        if (!isset($data['company_name']) || !isset($data['contact_person']) || !isset($data['telephone']) ||
            !isset($data['email']) || !isset($data['ico']) || !isset($data['dic']) || !isset($data['address'])
        ) {
            throw new ModelException("Missing data");
        }
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
}