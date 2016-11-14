<?php

namespace Model;


use PDO;

class AbstractModel
{
    private static $connection;

    protected function getConnection()
    {
        if (!self::$connection) {
//            $connection = new PDO('mysql:host=localhost;dbname=' . DATABASE_DB_NAME, DATABASE_USERNAME, DATABASE_PASSWORD);
            $connection = new PDO("");
            $connection->exec("set names utf8");
            self::$connection = $connection;
        }
        return self::$connection;
    }

    protected function query($sql, $params)
    {
        $connection = $this->getConnection();
        $preparedStatement = $connection->prepare($sql);
        $preparedStatement->execute($params);
        if ((int)$connection->errorCode()) {
            $errorInfo = $connection->errorInfo();
            throw new \Exception($errorInfo[2], $connection->errorCode());
        }
        return $preparedStatement->fetchAll(PDO::FETCH_ASSOC);
    }
}