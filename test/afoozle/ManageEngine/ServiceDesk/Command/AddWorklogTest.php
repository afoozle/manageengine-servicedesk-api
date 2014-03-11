<?php
namespace afoozle\ManageEngine\ServiceDesk\Command\Worklog;

use afoozle\ManageEngine\ServiceDesk\CommandGateway;

class AddWorklogTest extends \PHPUnit_Framework_TestCase {

    private $technicianApiCode = '12377F1F-9181-4EAF-B761-B19BE37E39E7';
    private $servicedeskTicket = 97639;

    public function testGetOperationName()
    {
        $command = new AddWorklog();
        $this->assertEquals('ADD_WORKLOG', $command->getOperationName(), 'Error retrieving operation name');
    }

    public function testGetOperationUrl()
    {
        $command = new AddWorklog();
        $command->setRequestId(999);
        $this->assertEquals('/sdpapi/request/999/worklogs', $command->getOperationUrl(), "Url was not mapped correctly");
    }

    public function testToXmlWithEmptyValues()
    {
        $command = new AddWorklog();
        $expectedResult = <<<ENDXML
<Operation>
    <Details>
        <Worklogs>
            <Worklog>
                <description/>
                <technician/>
                <cost/>
                <workMinutes/>
                <workHours/>
            </Worklog>
        </Worklogs>
    </Details>
</Operation>
ENDXML;

        $this->assertXmlStringEqualsXmlString($expectedResult, $command->toXml(), "XML was not mapped correctly");
    }

    public function testToXmlWithAllValues()
    {
        $command = new AddWorklog();
        $command
            ->setDescription('dummy description')
            ->setTechnician('dummy technician')
            ->setCost(999)
            ->setWorkMinutes(111)
            ->setWorkHours(555);

        $expectedResult = <<<ENDXML
<Operation>
    <Details>
        <Worklogs>
            <Worklog>
                <description>dummy description</description>
                <technician>dummy technician</technician>
                <cost>999</cost>
                <workMinutes>111</workMinutes>
                <workHours>555</workHours>
            </Worklog>
        </Worklogs>
    </Details>
</Operation>
ENDXML;

        $this->assertXmlStringEqualsXmlString($expectedResult, $command->toXml(), "XML was not mapped correctly");
    }

    public function testProcessSuccessfulResponse()
    {
        $command = new AddWorklog();
        $responseText = <<<RESPONSE
<?xml version="1.0" encoding="UTF-8"?>
<operation name="ADD_WORKLOG">
    <result>
        <status>Success</status>
        <message>Work Log added successfully for request 24</message>
    </result>
</operation>
RESPONSE;

        $command->processResponse($responseText);
        $this->assertEquals(true, $command->wasSuccessful(), "Response parsed incorrectly");
    }

    public function testProcessFailedResponse()
    {
        $command = new AddWorklog();
        $responseText = <<<RESPONSE
<?xml version="1.0" encoding="UTF-8"?>
<operation name="ADD_WORKLOG">
    <result>
        <status>Failure</status>
        <message>Some Random message now</message>
    </result>
</operation>
RESPONSE;

        $command->processResponse($responseText);
        $this->assertEquals(false, $command->wasSuccessful(), "Response parsed incorrectly");
    }

    public function testLiveRequest()
    {
        $command = new AddWorklog();
        $command
            ->setRequestId($this->servicedeskTicket)
            ->setDescription('test description')
            ->setTechnician('Matthew Wheeler')
            ->setWorkMinutes(15);

        $commandGateway = new CommandGateway('http://servicedesk.peakadventuretravel.com/', $this->technicianApiCode);
        $commandGateway->executeCommand($command);

        $this->assertEquals(true, $command->wasSuccessful(), "Command failed, log:\n".var_export($command->getLogs(),true));
    }

}
