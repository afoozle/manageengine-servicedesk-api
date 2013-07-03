<?php

namespace afoozle\ManageEngine\ServiceDesk\ApiCommand;

use Buzz\Browser;
use Buzz\Message\Response;

class CommandGatewayTest extends \PHPUnit_Framework_TestCase {

    public function tearDown()
    {
        \Mockery::close();
    }

    public function testObjectInstantiation()
    {
        $commandGateway = new CommandGateway('http://example.com','abc123');
    }

    public function testExecuteCommandWithSuccess()
    {
        $dummyPayload = '<operation></operation>';

        $mockedCommand = \Mockery::mock('\afoozle\ManageEngine\ServiceDesk\ApiCommand\CommandInterface');
        $mockedCommand->shouldReceive('toXml')->withNoArgs()->andReturn($dummyPayload);
        $mockedCommand->shouldReceive('getOperationName')->withNoArgs()->andReturn('MOCK_OPERATION');
        $mockedCommand->shouldReceive('getOperationUrl')->withNoArgs()->andReturn('/sdpapi/request/mock');
        $mockedCommand->shouldReceive('processResponse')->withAnyArgs();

        $mockedResponse = \Mockery::mock('\Buzz\Message\Response');
        $mockedResponse->shouldReceive('getStatusCode')->andReturn(200);
        $mockedResponse->shouldReceive('getContent')->andReturn('');

        $mockedBrowser = \Mockery::mock('\Buzz\Browser');
        $mockedBrowser
            ->shouldReceive('send')
            ->with(\Mockery::type('\Buzz\Message\Form\FormRequest'))
            ->andReturn($mockedResponse);

        $commandGateway = new CommandGateway('http://example.com', 'abc123', $mockedBrowser);

        $commandGateway->executeCommand($mockedCommand);
    }

    public function testExecuteCommandWithFailure()
    {
        $dummyPayload = '<operation></operation>';

        $mockedCommand = \Mockery::mock('\afoozle\ManageEngine\ServiceDesk\ApiCommand\CommandInterface');
        $mockedCommand->shouldReceive('toXml')->withNoArgs()->andReturn($dummyPayload);
        $mockedCommand->shouldReceive('getOperationName')->withNoArgs()->andReturn('MOCK_OPERATION');
        $mockedCommand->shouldReceive('getOperationUrl')->withNoArgs()->andReturn('/sdpapi/request/mock');
        $mockedCommand->shouldReceive('addLog')->withAnyArgs();
        $mockedCommand->shouldReceive('setWasSuccessful')->with(false);

        $mockedResponse = \Mockery::mock('\Buzz\Message\Response');
        $mockedResponse->shouldReceive('getStatusCode')->andReturn(500);
        $mockedResponse->shouldReceive('getContent')->andReturn('');

        $mockedBrowser = \Mockery::mock('\Buzz\Browser');
        $mockedBrowser
            ->shouldReceive('send')
            ->with(\Mockery::type('\Buzz\Message\Form\FormRequest'))
            ->andReturn($mockedResponse);

        $commandGateway = new CommandGateway('http://example.com', 'abc123', $mockedBrowser);

        $commandGateway->executeCommand($mockedCommand);
    }
}
