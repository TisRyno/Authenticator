<?php
namespace RmAuthenticatorBundle\Authenticator\Gateways\GitHub;

use Github\Client;
use Psr\Log\LoggerInterface;
use RmAuthenticatorBundle\Authenticator\Common\AbstractGateway;

class Gateway extends AbstractGateway
{
    /**
     * @var Client
     */
    protected $githubClient;

    /**
     * Gateway constructor.
     *
     * @param LoggerInterface $logger
     * @param array $parameters
     */
    public function __construct(LoggerInterface $logger, $parameters = [])
    {
        parent::__construct($logger, $parameters);

        $this->createConnection();
    }

    /**
     * Creates the default connection to Facebook
     */
    public function createConnection()
    {
        $this->githubClient = new Client();
    }
}
