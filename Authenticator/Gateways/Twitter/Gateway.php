<?php
namespace RmAuthenticatorBundle\Authenticator\Gateways\Twitter;

use Abraham\TwitterOAuth\TwitterOAuth;
use Psr\Log\LoggerInterface;
use RmAuthenticatorBundle\Authenticator\Common\AbstractGateway;

class Gateway extends AbstractGateway
{
    /**
     * @var TwitterOAuth
     */
    protected $twitterClient;

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
     * Creates the default connection to Twitter
     */
    public function createConnection()
    {
        $this->twitterClient = new TwitterOAuth(
            $this->getParameter('consumer_key'),
            $this->getParameter('consumer_secret'),
            $this->getParameter('client_id'),
            $this->getParameter('secret')
        );
    }
}
