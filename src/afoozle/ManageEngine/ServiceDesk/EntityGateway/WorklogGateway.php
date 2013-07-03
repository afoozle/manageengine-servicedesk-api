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
namespace afoozle\ManageEngine\ServiceDesk\EntityGateway;

use afoozle\ManageEngine\ServiceDesk\ApiCommand\AddWorklog;
use afoozle\ManageEngine\ServiceDesk\ApiCommand\CommandGateway;
use afoozle\ManageEngine\ServiceDesk\Entity\Worklog;

class WorklogGateway implements EntityGatewayInterface {

    /**
     * @var CommandGateway
     */
    private $commandGateway = null;

    public function __construct(CommandGateway $commandGateway)
    {
        $this->commandGateway = $commandGateway;
    }

    /**
     * Create a new worklog object
     *
     * @return Worklog
     */
    public function createNew()
    {
        return new Worklog();
    }

    public function save(Worklog $worklog)
    {
        if ($worklog->getId() == null) {
            $apiCommand = new AddWorklog();
            $apiCommand->setRequestId($worklog->getRequestId());
            $apiCommand->setTechnician($worklog->getTechnician());
            $apiCommand->setDescription($worklog->getDescription());
            $apiCommand->setWorkMinutes($worklog->getMinutes());
            // executed time?
        }
        else {
            throw new \Exception("Update not implemented yet");
        }

       $this->commandGateway->executeCommand($apiCommand);
       return $apiCommand->wasSuccessful();
    }
}