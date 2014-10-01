<?php

namespace TradedoublerReportWrapper;

use AffiliateInterface\TransactionInterface;

class Transaction implements TransactionInterface
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $type;

    /**
     * @var \DateTime
     */
    protected $clickedAt;

    /**
     * @var string
     */
    protected $epi;

    /**
     * @var Program
     */
    protected $program;

    /**
     * @var Channel
     */
    protected $channel;

    /**
     * @var string
     */
    protected $orderId;

    /**
     * @var int
     */
    protected $orderValue;

    /**
     * @var int
     */
    protected $commission;

    /**
     * @var \DateTime
     */
    protected $createdAt;

    public function __construct()
    {
        $this->clickedAt = null;
    }

    /**
     * @param \TradedoublerReportWrapper\Channel $channel
     */
    public function setChannel($channel)
    {
        $this->channel = $channel;
    }

    /**
     * @return \TradedoublerReportWrapper\Channel
     */
    public function getChannel()
    {
        return $this->channel;
    }

    /**
     * @param \DateTime $clickedAt
     */
    public function setClickedAt($clickedAt)
    {
        $this->clickedAt = $clickedAt;
    }

    /**
     * @return \DateTime
     */
    public function getClickedAt()
    {
        return $this->clickedAt;
    }

    /**
     * @param int $commission
     */
    public function setCommission($commission)
    {
        $this->commission = $commission;
    }

    /**
     * @return int
     */
    public function getCommission()
    {
        return $this->commission;
    }

    /**
     * @param \DateTime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param string $epi
     */
    public function setEpi($epi)
    {
        $this->epi = $epi;
    }

    /**
     * @return string
     */
    public function getEpi()
    {
        return $this->epi;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    public function getOriginalId()
    {
        return $this->getId();
    }

    /**
     * @param string $orderId
     */
    public function setOrderId($orderId)
    {
        $this->orderId = $orderId;
    }

    /**
     * @return string
     */
    public function getOrderId()
    {
        return $this->orderId;
    }

    /**
     * @param int $orderValue
     */
    public function setOrderValue($orderValue)
    {
        $this->orderValue = $orderValue;
    }

    /**
     * @return int
     */
    public function getOrderValue()
    {
        return $this->orderValue;
    }

    /**
     * @param \TradedoublerReportWrapper\Program $program
     */
    public function setProgram($program)
    {
        $this->program = $program;
    }

    /**
     * @return \TradedoublerReportWrapper\Program
     */
    public function getProgram()
    {
        return $this->program;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }
}


