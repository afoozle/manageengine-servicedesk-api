<?php
namespace afoozle\ManageEngine\ServiceDesk\ApiCommand;

class AddWorklog extends CommandAbstract {

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
}