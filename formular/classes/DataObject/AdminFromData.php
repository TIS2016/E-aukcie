<?php

namespace DataObject;

use DateTime;
use Model\ModelException;


class AdminFromData
{
    /**
     * @var int
     */
    private $project;
    /**
     * @var string
     */
    private $currency;
    /**
     * @var string
     */
    private $status;
    /**
     * @var string
     */
    private $type;
    /**
     * @var string
     */
    private $nazov;

    /**
     * @var string
     */
    private $vyhlasovatel;

    /**
     * @var string
     */
    private $prevadzkovatel;

    /**
     * @var string
     */
    private $predmet;

    /**
     * @var string
     */
    private $pozadovanePodklady;

    /**
     * @varstring
     */
    private $kriteria;

    /**
     * @var DateTime
     */
    private $terminDorucenia;

    /**
     * @var DateTime
     */
    private $terminOdovzdania;

    /**
     * @var DateTime
     */
    private $terminAukcie;

    /**
     * @return int
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * @param int $project
     * @return $this
     */
    public function setProject($project)
    {
        $this->project = $project;
        return $this;
    }

    /**
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @param string $currency
     * @return $this
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;
        return $this;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     * @return $this
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return string
     */
    public function getNazov()
    {
        return $this->nazov;
    }

    /**
     * @param string $nazov
     * @return $this
     */
    public function setNazov($nazov)
    {
        $this->nazov = $nazov;
        return $this;
    }

    /**
     * @return string
     */
    public function getVyhlasovatel()
    {
        return $this->vyhlasovatel;
    }

    /**
     * @param string $vyhlasovatel
     * @return $this
     * @throws ModelException
     */
    public function setVyhlasovatel($vyhlasovatel)
    {
        if ($vyhlasovatel == '') {
            throw new ModelException("Wrong format");
        }
        $this->vyhlasovatel = $vyhlasovatel;
        return $this;
    }

    /**
     * @return string
     */
    public function getPrevadzkovatel()
    {
        return $this->prevadzkovatel;
    }

    /**
     * @param string $prevadzkovatel
     * @return $this
     */
    public function setPrevadzkovatel($prevadzkovatel)
    {
        $this->prevadzkovatel = $prevadzkovatel;
        return $this;
    }

    /**
     * @return string
     */
    public function getPredmet()
    {
        return $this->predmet;
    }

    /**
     * @param string $predmet
     * @return $this
     */
    public function setPredmet($predmet)
    {
        $this->predmet = $predmet;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getTerminDorucenia()
    {
        return $this->terminDorucenia;
    }

    /**
     * @param DateTime $temrinDorucenia
     * @return $this
     */
    public function setTerminDorucenia($temrinDorucenia)
    {
        $this->terminDorucenia = $temrinDorucenia;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getTerminOdovzdania()
    {
        return $this->terminOdovzdania;
    }

    /**
     * @param DateTime $terminOdovzdania
     * @return $this
     */
    public function setTerminOdovzdania($terminOdovzdania)
    {
        $this->terminOdovzdania = $terminOdovzdania;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getTerminAukcie()
    {
        return $this->terminAukcie;
    }

    /**
     * @param DateTime $terminAukcie
     * @return $this
     */
    public function setTerminAukcie($terminAukcie)
    {
        $this->terminAukcie = $terminAukcie;
        return $this;
    }

    /**
     * @return string
     */
    public function getPozadovanePodklady()
    {
        return $this->pozadovanePodklady;
    }

    /**
     * @param string $pozadovanePodklady
     */
    public function setPozadovanePodklady($pozadovanePodklady)
    {
        $this->pozadovanePodklady = $pozadovanePodklady;
    }

    /**
     * @return mixed
     */
    public function getKriteria()
    {
        return $this->kriteria;
    }

    /**
     * @param mixed $kriteria
     * @return $this
     */
    public function setKriteria($kriteria)
    {
        $this->kriteria = $kriteria;
        return $this;
    }

    /**
     * @return array
     */
    public function getDataArray()
    {
        $res = array();
        $res['projectId'] = $this->project;
        $res['auctionCurrency'] = $this->currency;
        $res['auctionStatus'] = $this->status;
        $res['auctionType'] = $this->type;
        $res['nazov'] = $this->nazov;
        $res['vyhlasovatel'] = $this->vyhlasovatel;
        $res['prevadzkovatel'] = $this->prevadzkovatel;
        $res['predmet'] = $this->predmet;
        $res['pozadovanePodklady'] = $this->pozadovanePodklady;
        $res['kriteria'] = $this->kriteria;
        $res['temrinDorucenia'] = $this->terminDorucenia;
        $res['terminOdovzdania'] = $this->terminOdovzdania;
        $res['terminAukcie'] = $this->terminAukcie;
        return $res;
    }
}