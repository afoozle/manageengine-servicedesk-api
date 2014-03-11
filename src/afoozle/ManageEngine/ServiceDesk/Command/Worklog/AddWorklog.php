<?php
namespace afoozle\ManageEngine\ServiceDesk\Command\Worklog;

use afoozle\ManageEngine\ServiceDesk\Command\CommandAbstract;
use afoozle\ManageEngine\ServiceDesk\Command\CommandInterface;

/**
 * @link http://www.manageengine.com/products/service-desk/help/adminguide/api/worklog-operations.html
 */
class AddWorklog extends CommandAbstract implements CommandInterface {

    /**
     * @var int
     */
    private $requestId = null;

    /**
     * @var string
     */
    private $description = null;

    /**
     * @var string
     */
    private $technician = null;

    /**
     * @var int
     */
    private $cost = null;

    /**
     * @var int
     */
    private $workMinutes = null;

    /**
     * @var int
     */
    private $workHours = null;

    /**
     * @var \DateTime
     */
    private $startTime = null;

    /**
     * @var \DateTime
     */
    private $executedTime = null;

    /**
     * @return string
     */
    public function getOperationName()
    {
        return 'ADD_WORKLOG';
    }

    /**
     * @return string
     */
    public function getOperationUrl()
    {
        return sprintf('/sdpapi/request/%d/worklogs', $this->getRequestId());
    }

    /**
     * @return string
     */
    public function toXml()
    {
        $fragment = new \DOMDocument();
        $operationTag = new \DOMElement('Operation');
        $fragment->appendChild($operationTag);

        $detailsTag = new \DOMElement('Details');
        $operationTag->appendChild($detailsTag);

        $worklogsTag = new \DOMElement('Worklogs');
        $detailsTag->appendChild($worklogsTag);

        $worklogTag = new \DOMElement('Worklog');
        $worklogsTag->appendChild($worklogTag);

        $worklogTag->appendChild(new \DOMElement('description',$this->getDescription()));
        $worklogTag->appendChild(new \DOMElement('technician', $this->getTechnician()));
        $worklogTag->appendChild(new \DOMElement('cost', $this->getCost()));
        $worklogTag->appendChild(new \DOMElement('workMinutes', $this->getWorkMinutes()));
        $worklogTag->appendChild(new \DOMElement('workHours', $this->getWorkHours()));

        if ($this->getStartTime() !== null) {
            $worklogTag->appendChild(new \DomElement('startTime', $this->getStartTime()->format(DATE_W3C)));
        }

        $endTime = $this->getEndTime();
        if ($endTime !== null) {
            $worklogTag->appendChild(new \DomElement('endTime', $endTime->format(DATE_W3C)));
        }

        // executedTime
        if ($this->getExecutedTime() !== null) {
            $worklogTag->appendChild(new \DOMElement('executedTime', $this->getExecutedTime()->format(DATE_W3C)));
        }

        return $fragment->saveXML($operationTag);
    }

    /**
     * @param string $response
     */
    public function processResponse($response)
    {
        $dom = new \DOMDocument();
        $dom->loadXML($response);
        $xpath = new \DOMXPath($dom);
        $entries = $xpath->query('//operation/result/status');

        if (strtolower($entries->item(0)->nodeValue) == "success") {
            $this->setWasSuccessful(true);
        }
    }

    /**
     * @param int $cost
     * @return self
     */
    public function setCost($cost)
    {
        $this->cost = $cost;
        return $this;
    }

    /**
     * @return int
     */
    public function getCost()
    {
        return $this->cost;
    }

    /**
     * @param string $description
     * @return self
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $technician
     * @return self
     */
    public function setTechnician($technician)
    {
        $this->technician = $technician;
        return $this;
    }

    /**
     * @return string
     */
    public function getTechnician()
    {
        return $this->technician;
    }

    /**
     * @param int $workHours
     * @return self
     */
    public function setWorkHours($workHours)
    {
        $this->workHours = $workHours;
        return $this;
    }

    /**
     * @return int
     */
    public function getWorkHours()
    {
        return $this->workHours;
    }

    /**
     * @param int $workMinutes
     * @return self
     */
    public function setWorkMinutes($workMinutes)
    {
        $this->workMinutes = $workMinutes;
        return $this;
    }

    /**
     * @return int
     */
    public function getWorkMinutes()
    {
        return $this->workMinutes;
    }

    /**
     * @param int $requestId
     * @return self
     */
    public function setRequestId($requestId)
    {
        $this->requestId = $requestId;
        return $this;
    }

    /**
     * @return int
     */
    public function getRequestId()
    {
        return $this->requestId;
    }

    /**
     * @param \DateTime $startTime
     */
    public function setStartTime(\DateTime $startTime = null)
    {
        $this->startTime = $startTime;
    }

    /**
     * @return \DateTime
     */
    public function getStartTime()
    {
        return $this->startTime;
    }

    /**
     * Calculate and return the end time given the start time and work hours
     *
     * @return \DateTime
     */
    public function getEndTime()
    {
        $endTime = new \DateTime('now');
        if ($this->getStartTime() !== null && ($this->getWorkHours() > 0 || $this->getWorkMinutes() > 0)) {

            $timespanSeconds = 0;
            if ($this->getWorkHours() > 0) {
                $timespanSeconds += $this->getWorkHours() * 3600;
            }
            if ($this->getWorkMinutes() > 0) {
                $timespanSeconds += $this->getWorkMinutes() * 60;
            }

            if ($timespanSeconds > 0) {
                $endTime = clone($this->getStartTime());
                $endTime->add(new \DateInterval('PT'.$timespanSeconds.'S'));
                return $endTime;
            }
        }
        return null;
    }

    /**
     * @param \DateTime $executedTime
     */
    public function setExecutedTime(\DateTime $executedTime)
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
}