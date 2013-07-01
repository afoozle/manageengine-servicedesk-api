<?php
/**
 * Worklog Entity
 *
 * Copyright (c) Matthew Wheeler <matt@yurisko.net>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 *
 * @author     Matthew Wheeler <matt@yurisko.net>
 * @license    MIT
 */
namespace afoozle\ManageEngine\ServiceDesk\Entity;

/**
 * Class Worklog
 *
 * Represents a single worklog entity
 *
 * @package afoozle\ManageEngine\ServiceDesk\Entity
 */
class Worklog implements EntityInterface {

    /**
     * @var
     */
    private $id = null;

    /**
     * @var int
     */
    private $requestId = null;

    /**
     * @var string
     */
    private $technician = null;

    /**
     * @var string
     */
    private $description = null;

    /**
     * @var int
     */
    private $minutes = null;

    /**
     * @var int
     */
    private $cost = null;

    /**
     * @var \DateTime
     */
    private $dateTime = null;

    /**
     * @var \DateTime
     */
    private $executedTime = null;

    /**
     * Entity Constructor
     */
    public function __construct()
    {

    }

    /**
     * @param int $cost
     */
    public function setCost($cost)
    {
        $this->cost = $cost;
    }

    /**
     * @return int
     */
    public function getCost()
    {
        return $this->cost;
    }

    /**
     * @param \DateTime $dateTime
     */
    public function setDateTime($dateTime)
    {
        $this->dateTime = $dateTime;
    }

    /**
     * @return \DateTime
     */
    public function getDateTime()
    {
        return $this->dateTime;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param \DateTime $executedTime
     */
    public function setExecutedTime($executedTime)
    {
        $this->executedTime = $executedTime;
    }

    /**
     * @return \DateTime
     */
    public function getExecutedTime()
    {
        return $this->executedTime;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $minutes
     */
    public function setMinutes($minutes)
    {
        $this->minutes = $minutes;
    }

    /**
     * @return int
     */
    public function getMinutes()
    {
        return $this->minutes;
    }

    /**
     * @param int $requestId
     */
    public function setRequestId($requestId)
    {
        $this->requestId = $requestId;
    }

    /**
     * @return int
     */
    public function getRequestId()
    {
        return $this->requestId;
    }

    /**
     * @param string $technician
     */
    public function setTechnician($technician)
    {
        $this->technician = $technician;
    }

    /**
     * @return string
     */
    public function getTechnician()
    {
        return $this->technician;
    }


}