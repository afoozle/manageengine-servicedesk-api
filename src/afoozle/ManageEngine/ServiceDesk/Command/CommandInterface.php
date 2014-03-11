<?php
/**
 * Created by JetBrains PhpStorm.
 * User: afoozle
 * Date: 3/07/13
 * Time: 4:37 PM
 * To change this template use File | Settings | File Templates.
 */

namespace afoozle\ManageEngine\ServiceDesk\Command;


interface CommandInterface {

    /**
     * @return string
     */
    public function getOperationName();

    /**
     * @return string
     */
    public function getOperationUrl();

    /**
     * @return string
     */
    public function toXml();

    /**
     * @param string $response
     */
    public function processResponse($response);

    /**
     * @return bool
     */
    public function wasSuccessful();


    /**
     * @param bool $wasSuccessful
     * return self
     */
    public function setWasSuccessful($wasSuccessful);

    /**
     * @param string $message
     */
    public function addLog($message);

    /**
     * @return array
     */
    public function getLogs();
}