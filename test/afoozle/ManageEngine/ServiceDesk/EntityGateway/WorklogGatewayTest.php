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

use afoozle\ManageEngine\ServiceDesk\ApiCommand\CommandGateway;
use afoozle\ManageEngine\ServiceDesk\Entity\Worklog;

class WorklogGatewayTest extends \PHPUnit_Framework_TestCase {

    public function testObjectCreation()
    {
        $worklogGateway = new WorklogGateway(new CommandGateway('http://example.com','abc-123'));
    }

    public function testSaveWithNoIdCallsAddWorklog()
    {
        $commandGateway = \Mockery::mock('afoozle\ManageEngine\ServiceDesk\ApiCommand\CommandGateway');
        $commandGateway
            ->shouldReceive('executeCommand')
            ->with(\Mockery::type('afoozle\ManageEngine\ServiceDesk\ApiCommand\AddWorklog'));

        $worklogGateway = new WorklogGateway($commandGateway);
        $worklogGateway->save(new Worklog());
    }
}
