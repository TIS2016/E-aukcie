<?php
/**
 * Created by PhpStorm.
 * User: Tomi
 * Date: 2016.12.05.
 * Time: 18:38
 */

namespace Model;


use DataObject\AuctionCurrencyData;
use DataObject\AuctionStatusData;
use DataObject\AuctionTypeData;

class AuctionFkModel extends AbstractModel
{
    public function getCurrencies()
    {
        $sql = 'SELECT * FROM c_currency';
        $result = $this->query($sql, array());
        $currencies = array();
        foreach ($result as $row) {
            $currency = new AuctionCurrencyData();
            $currency->setId($row['id'])->setDescription($row['description']);
            $currencies[] = $currency;
        }
        return $currencies;
    }

    public function getStatuses()
    {
        $sql = 'SELECT * FROM c_auction_status';
        $result = $this->query($sql, array());
        $statuses = array();
        foreach ($result as $row) {
            $status = new AuctionStatusData();
            $status->setId($row['id'])->setDescription($row['description']);
            $statuses[] = $status;
        }
        return $statuses;
    }

    public function getTypes()
    {
        $sql = 'SELECT * FROM c_auction_type';
        $result = $this->query($sql, array());
        $types = array();
        foreach ($result as $row) {
            $type = new AuctionTypeData();
            $type->setId($row['id'])->setDescription($row['description']);
            $types[] = $type;
        }
        return $types;
    }
}