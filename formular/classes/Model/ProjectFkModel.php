<?php
namespace Model;


use DataObject\ClientData;
use DataObject\OwnerData;

class ProjectFkModel extends AbstractModel
{
    public function getClients()
    {
        $sql = 'SELECT id, company_name FROM client';
        $result = $this->query($sql, array());
        $clients = array();
        foreach ($result as $row) {
            $client = new ClientData();
            $client->setId($row['id'])->setName($row['company_name']);
            $clients[] = $client;
        }
        return $clients;
    }

    public  function getOwners(){
        $sql = 'SELECT login, name FROM users';
        $result = $this->query($sql, array());
        $owners = array();
        foreach ($result as $row) {
            $owner = new OwnerData();
            $owner->setLogin($row['login'])->setName($row['name']);
            $owners[] = $owner;
        }
        return $owners;
    }
}