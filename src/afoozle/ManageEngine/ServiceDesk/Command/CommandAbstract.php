<?php
/**
 * Created by JetBrains PhpStorm.
 * User: afoozle
 * Date: 3/07/13
 * Time: 4:38 PM
 * To change this template use File | Settings | File Templates.
 */

namespace afoozle\ManageEngine\ServiceDesk\ApiCommand;

abstract class CommandAbstract implements CommandInterface {

    /**
     * @var bool
     */
    private $wasSuccessful = false;

    /**
     * @var array
     */
    private $logs = array();

    /**
     * @return bool
     */
    public function wasSuccessful()
    {
        return $this->wasSuccessful;
    }

    /**
     * @param bool $wasSuccessful
     * @return self
     */
    public function setWasSuccessful($wasSuccessful)
    {
        $this->wasSuccessful = $wasSuccessful;
        return $this;
    }

    /**
     * @param string $message
     */
    public function addLog($message)
    {
        $this->logs[] = $message;
    }

    /**
     * @return array
     */
    public function getLogs()
    {
        return $this->logs;
    }
}