<?php
namespace afoozle\ManageEngine\ServiceDesk\Command\Worklog;

use afoozle\ManageEngine\ServiceDesk\CommandGateway;

class GetWorklogTest extends \PHPUnit_Framework_TestCase {

    public function testLiveRequest()
    {
        $this->markTestSkipped('This isnt written yet');
        return;
//        $command = new GetWorklog();
//        $command
//            ->setRequestId(84062)
//            ->setWorklogId(6118);
//
//        $commandGateway = new CommandGateway('http://servicedesk.peakadventuretravel.com/', '1B0634E2-369C-4225-BC91-161FBF0EF022');
//        $commandGateway->executeCommand($command);
//
//        $this->assertEquals(true, $command->wasSuccessful(), "Command failed, log:\n".var_export($command->getLogs(),true));
    }

}
