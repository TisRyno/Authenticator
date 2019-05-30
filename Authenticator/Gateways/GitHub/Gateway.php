<?php
namespace RmAuthenticatorBundle\Authenticator\Gateways\GitHub;

use Github\Client;
use RmAuthenticatorBundle\Authenticator\Common\AbstractGateway;

class Gateway extends AbstractGateway
{
    /**
     * @var Client
     */
    protected $githubClient;

    /**
     * Creates the default connection to Facebook
     */
    public function createConnection()
    {
        $this->githubClient = new Client();
    }
}
