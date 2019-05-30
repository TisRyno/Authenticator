<?php
namespace RmAuthenticatorBundle\Authenticator\Common;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\MessageFormatter;
use GuzzleHttp\Middleware;
use Psr\Log\LoggerInterface;
use GuzzleHttp\Client;

abstract class AbstractGateway
{
    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @var Client
     */
    protected $httpClient;

    /**
     * @see MessageFormatter for formatting options
     */
    const DEBUG_FORMAT = ">>>>>>>>\n{method} {uri} HTTP/{version} {req_body}\n<<<<<<<<\nRESPONSE: {code} - {res_body}\n--------\n{error}\n";

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;

        $this->createDefaultHttpClient();
    }

    /**
     * Create the global default HTTP client with relevant settings
     *
     * @return HttpClient
     */
    protected function createDefaultHttpClient()
    {
        $stack = HandlerStack::create();

        $stack->push(
            Middleware::log(
                $this->logger,
                new MessageFormatter($this::DEBUG_FORMAT)
            )
        );

        $this->httpClient = new HttpClient([
            'handler' => $stack
        ]);
    }
}
