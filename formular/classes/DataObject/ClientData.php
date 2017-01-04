<?php
namespace DataObject;


class ClientData
{
    /**
     * @var int
     */
    private $id;
    /**
     * @var string
     */
    private $name;
    /**
     * @var int
     */
    private $ico;
    /**
     * @var int
     */
    private $dic;
    /**
     * @var string
     */
    private $address;
    /**
     * @var string
     */
    private $tel;
    /**
     * @var string
     */
    private $email;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return int
     */
    public function getIco()
    {
        return $this->ico;
    }

    /**
     * @param int $ico
     * @return $this
     */
    public function setIco($ico)
    {
        $this->ico = $ico;
        return $this;
    }

    /**
     * @return int
     */
    public function getDic()
    {
        return $this->dic;
    }

    /**
     * @param int $dic
     * @return $this
     */
    public function setDic($dic)
    {
        $this->dic = $dic;
        return $this;
    }

    /**
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param string $address
     * @return $this
     */
    public function setAddress($address)
    {
        $this->address = $address;
        return $this;
    }

    /**
     * @return string
     */
    public function getTelephone()
    {
        return $this->tel;
    }

    /**
     * @param string $tel
     * @return $this
     */
    public function setTelephone($tel)
    {
        $this->tel = $tel;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return $this
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

}