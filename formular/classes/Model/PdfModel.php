<?php
namespace Model;


class PdfModel extends AbstractModel
{
    /**
     * @return integer
     */
    public function getAuctionId(){
        return $this->query('SELECT max(id) FROM auction', array())[0]['max'] + 1;
    }

}
