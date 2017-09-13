<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Transaction
 *
 * @ORM\Table(name="transaction")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TransactionRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Transaction
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
     * Many Features have One Product.
     * @ManyToOne(targetEntity="Account", inversedBy="transactions")
     * @JoinColumn(name="account_id", referencedColumnName="id")
     */

    /**
     * @var int
     *
     * @ORM\Column(name="account_id", type="integer")
     */
    private $accountId;

    /**
     * @var string
     *
     * @ORM\Column(name="credit_Amount", type="decimal", precision=10, scale=2)
     */
    private $creditAmount;

    /**
     * @var string
     *
     * @ORM\Column(name="debit_Amount", type="decimal", precision=10, scale=2)
     */
    private $debitAmount;

    /**
     * @var string
     *
     * @ORM\Column(name="balance_Amount", type="decimal", precision=10, scale=2)
     */
    private $balanceAmount;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="transaction_date", type="datetime")
     */
    private $transactionDate;


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
     * Set accountNumber
     *
     * @param integer $accountNumber
     *
     * @return Transaction
     */
    public function setAccountId($accountId)
    {
        $this->accountId = $accountId;

        return $this;
    }

    /**
     * Get accountNumber
     *
     * @return int
     */
    public function getaccountId()
    {
        return $this->accountId;
    }

    /**
     * Set creditAmount
     *
     * @param string $creditAmount
     *
     * @return Transaction
     */
    public function setCreditAmount($creditAmount)
    {
        $this->creditAmount = $creditAmount;

        return $this;
    }

    /**
     * Get creditAmount
     *
     * @return string
     */
    public function getCreditAmount()
    {
        return $this->creditAmount;
    }

    /**
     * Set debitAmount
     *
     * @param string $debitAmount
     *
     * @return Transaction
     */
    public function setDebitAmount($debitAmount)
    {
        $this->debitAmount = $debitAmount;

        return $this;
    }

    /**
     * Get debitAmount
     *
     * @return string
     */
    public function getDebitAmount()
    {
        return $this->debitAmount;
    }

    /**
     * Set balanceAmount
     *
     * @param string $balanceAmount
     *
     * @return Transaction
     */
    public function setBalanceAmount($balanceAmount)
    {
        $this->balanceAmount = $balanceAmount;

        return $this;
    }

    /**
     * Get balanceAmount
     *
     * @return string
     */
    public function getBalanceAmount()
    {
        return $this->balanceAmount;
    }

    /**
     * Set transactionDate
     *
     * @ORM\PrePersist
     *
     * @param \DateTime $transactionDate
     *
     * @return Transaction
     */
    public function setTransactionDate()
    {
        
        if(!isset($this->transactionDate)) 
          $this->transactionDate = new \DateTime();

        return $this;
    }

    /**
     * Get transactionDate
     *
     * @return \DateTime
     */
    public function getTransactionDate()
    {
        return $this->transactionDate;
    }
}

