<?php
namespace afoozle\ManageEngine\ServiceDesk\Command\Worklog;

use afoozle\ManageEngine\ServiceDesk\Command\CommandAbstract;
use afoozle\ManageEngine\ServiceDesk\Command\CommandInterface;

/**
 * @link http://www.manageengine.com/products/service-desk/help/adminguide/api/worklog-operations.html
 */
class GetWorklog extends CommandAbstract implements CommandInterface {

    /**
     * @var int
     */
    private $requestId = null;

    /**
     * @var int
     */
    private $worklogId = null;

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
     * @param int $worklogId
     * @return self
     */
    public function setWorklogId($worklogId)
    {
        $this->worklogId = $worklogId;
        return $this;
    }

    /**
     * @return int
     */
    public function getWorklogId()
    {
        return $this->worklogId;
    }

    /**
     * @return string
     */
    public function getOperationName()
    {
        return 'GET_WORKLOG';
    }

    /**
     * @return string
     */
    public function getOperationUrl()
    {
        // /sdpapi/request/%d/worklogs/%d
        return sprintf('/sdpapi/request/%d/worklogs/%d', $this->getRequestId(), $this->getWorklogId());
    }

    /**
     * @return string
     */
    public function toXml()
    {
        return '';
    }

    /**
     * @param string $response
     */
    public function processResponse($response)
    {
        var_dump($response);
        // TODO: Implement processResponse() method.
    }
}