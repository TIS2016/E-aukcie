<?php

namespace Model;


use DataObject\AdminFromData;

class FormModel extends AbstractModel
{
    public function getFormData($urlParts)
    {
        if (isset($urlParts[FIRST_URL_INDEX + 1])){
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
            VALUES (:id, \'WAITING\', \'PRIVATE\', \'EURO\', 2, :name, :description);
        ';
        $this->query($sql, array(
                ':id' => $id,
                ':name' => $dataObject->getNazov(),
                ':description' => json_encode($preparedData))
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

        $dataObject->setNazov($data['name']);
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