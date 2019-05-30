<?php
namespace RmAuthenticatorBundle\Authenticator\Gateways\Facebook;

use Facebook\Facebook;
use RmAuthenticatorBundle\Authenticator\Common\AbstractGateway;

class Gateway extends AbstractGateway
{
    /**
     * @var Facebook
     */
    protected $facebookClient;

    /**
     * Creates the default connection to Facebook
     */
    public function createConnection()
    {
        $this->facebookClient = new Facebook([
            'app_id'     => $this->getParameter('app_id'),
            'app_secret' => $this->getParameter('secret'),
            'default_graph_version' => $this->getParameter('default_graph_version'),
        ]);
    }

    public function fetchUserData()
    {

    }
}
