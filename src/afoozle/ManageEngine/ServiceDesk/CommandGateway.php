<?php

namespace afoozle\ManageEngine\ServiceDesk;

use Buzz\Browser;
use Buzz\Client\Curl;
use Buzz\Message\Form\FormRequest;

class CommandGateway {

    /**
     * @var string
     */
    private $commandUrl = null;

    /**
     * @var string
     */
    private $technicianKey = null;

    /**
     * @var \Buzz\Browser
     */
    private $browser = null;

    public function __construct($commandUrl, $technicianKey, Browser $browser = null)
    {
        $this->commandUrl = $commandUrl;
        $this->technicianKey = $technicianKey;
        if ($browser === null) {
            $browser = new Browser(new Curl());
        }
        $this->browser = $browser;
    }

    /**
     * Execute a command against the API
     *
     * @param Command\CommandInterface $command
     * @return Command\CommandInterface
     */
    public function executeCommand(Command\CommandInterface $command)
    {
        $payload = array();

        $payload['INPUT_DATA'] = $command->toXml();
        $payload['OPERATION_NAME'] = $command->getOperationName();
        $payload['TECHNICIAN_KEY'] = $this->technicianKey;

        $formRequest = new FormRequest(FormRequest::METHOD_POST, $command->getOperationUrl(), $this->commandUrl);
        $formRequest->setField('INPUT_DATA', $command->toXml());
        $formRequest->setField('OPERATION_NAME', $command->getOperationName());
        $formRequest->setField('TECHNICIAN_KEY', $this->technicianKey);

        /** @var \Buzz\Message\Response $response */
        $response = $this->browser->send($formRequest);

        if ($response->getStatusCode() !== 200) {
            $command->setWasSuccessful(false);

            $errorMessage = <<<ENDMESSAGE
Unsuccessful response from SDP API:
    status_code: %s
    operation_url: %s
    payload: %s
    response: %s
ENDMESSAGE;
            $command->addLog(
                sprintf($errorMessage, $response->getStatusCode(), $command->getOperationUrl(), var_export($payload,true),$response->getContent())
            );
            return $command;
        }

        $command->processResponse($response->getContent());
        return $command;
    }

}