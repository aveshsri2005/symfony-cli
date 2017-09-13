<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Account
 *
 * @ORM\Table(name="account")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AccountRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Account
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;


    /**
     * An Account has Many Transaction.
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Transaction",mappedBy="account" )
     */  


    /**
     * @var string
     *
     * @ORM\Column(name="full_name", type="string", length=40)
     */
    private $fullName;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dob", type="date")
     */
    private $dob;

    /**
     * @var int
     *
     * @ORM\Column(name="mobile_number", type="bigint", unique=true)
     */
    private $mobileNumber;

    /**
     * @var int
     *
     * @ORM\Column(name="account_number", type="integer", unique=true, nullable=true)
     */
    private $accountNumber;

    /**
     * @var boolean
     *
     * @ORM\Column(name="status", type="boolean", nullable=true)
     */
    private $status;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_on", type="datetime")
     */
    private $createdOn;



    /**
     * Set id
     *
     * @param int $id
     *
     * @return Account
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set fullName
     *
     * @param string $fullName
     *
     * @return Account
     */
    public function setFullName($fullName)
    {
        $this->fullName = $fullName;

        return $this;
    }

    /**
     * Get fullName
     *
     * @return string
     */
    public function getFullName()
    {
        return $this->fullName;
    }

    /**
     * Set dob
     *
     * @param \DateTime $dob
     *
     * @return Account
     */
    public function setDob($dob)
    {
        $this->dob = $dob;

        return $this;
    }

    /**
     * Get dob
     *
     * @return \DateTime
     */
    public function getDob()
    {
        return $this->dob;
    }

    /**
     * Set mobileNumber
     *
     * @param integer $mobileNumber
     *
     * @return Account
     */
    public function setMobileNumber($mobileNumber)
    {
        $this->mobileNumber = $mobileNumber;

        return $this;
    }

    /**
     * Get mobileNumber
     *
     * @return int
     */
    public function getMobileNumber()
    {
        return $this->mobileNumber;
    }

    /**
     * Set accountNumber
     *
     * @param integer $accountNumber
     *
     * @return Account
     */
    public function setAccountNumber($accountNumber)
    {
        $this->accountNumber = $accountNumber;

        return $this;
    }

    /**
     * Get accountNumber
     *
     * @return int
     */
    public function getAccountNumber()
    {
        return $this->accountNumber;
    }

    /**
     * Set status
     *
     * @param boolean $status
     *
     * @return Account
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set createdOn
     *
     * @ORM\PrePersist
     *
     * @param \DateTime $createdOn
     *
     * @return Account
     */
    public function setCreatedOn()
    {
        if(!isset($this->createdOn)) 
        $this->createdOn = new \DateTime();

        return $this;
    }

    /**
     * Get createdOn
     *
     * @return \DateTime
     */
    public function getCreatedOn()
    {
        return $this->createdOn;
    }


}