<?php
namespace RmAuthenticatorBundle\Authenticator\Common;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\MessageFormatter;
use GuzzleHttp\Middleware;
use Psr\Log\LoggerInterface;
use GuzzleHttp\Client;
use Symfony\Component\HttpFoundation\ParameterBag;

abstract class AbstractGateway
{
    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @var ParameterBag
     */
    protected $parameters;

    /**
     * @var Client
     */
    protected $httpClient;

    /**
     * @see MessageFormatter for formatting options
     */
    const DEBUG_FORMAT = ">>>>>>>>\n{method} {uri} HTTP/{version} {req_body}\n<<<<<<<<\nRESPONSE: {code} - {res_body}\n--------\n{error}\n";

    public function __construct(LoggerInterface $logger, $parameters = [])
    {
        $this->logger = $logger;
        $this->parameters = new ParameterBag;

        $this->initialiseParameters($parameters);

        $this->createDefaultHttpClient();
    }

    /**
     * Initialise this gateway with default parameters
     *
     * @param  array $parameters
     * @return AbstractGateway
     */
    public function initialiseParameters(array $parameters = [])
    {
        foreach ($parameters as $key => $value) {
            $method = 'set'.ucfirst($this->camelCase($key));
            if (method_exists($this, $method)) {
                $this->$method($value);
            } else {
                $this->parameters->set($key, $value);
            }
        }

        return $this;
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

    /**
     * Convert a string to camelCase. Strings already in camelCase will not be harmed.
     *
     * @param  string  $str The input string
     * @return string camelCased output string
     */
    protected function camelCase($str)
    {
        return preg_replace_callback(
            '/_([a-z])/',
            function ($match) {
                return strtoupper($match[1]);
            },
            $str
        );
    }
    
    /**
     * @return array
     */
    public function getParameters()
    {
        return $this->parameters->all();
    }

    /**
     * @param  string $key
     * @return mixed
     */
    public function getParameter($key)
    {
        return $this->parameters->get($key);
    }

    /**
     * @param  string $key
     * @param  mixed  $value
     * @return $this
     */
    public function setParameter($key, $value)
    {
        $this->parameters->set($key, $value);

        return $this;
    }

    /**
     * @return boolean
     */
    public function getSandbox()
    {
        return $this->getParameter('sandbox');
    }

    /**
     * @param  boolean $value
     * @return $this
     */
    public function setSandbox($value)
    {
        return $this->setParameter('sandbox', $value);
    }
}
