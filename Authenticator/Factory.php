<?php
namespace RmAuthenticatorBundle\Authenticator;

use Psr\Log\LoggerInterface;
use RmAuthenticatorBundle\Authenticator\Common\GatewayInterface;
use RuntimeException;

class Factory
{
    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * Internal storage for settings
     *
     * @var array
     */
    private $settings;

    /**
     * Internal storage for all available gateways
     *
     * @var array
     */
    private $gateways;

    public function __construct(LoggerInterface $logger, array $settings, array $gateways)
    {
        $this->logger   = $logger;
        $this->settings = $settings;
        $this->gateways = $gateways;
    }

    /**
     * Automatically find and register all officially supported gateways
     *
     * @return array
     */
    public function all()
    {
        $gateways = [];

        foreach ($this->gateways as $name => $gateway) {
            $class = $gateway['gateway'];
            if (class_exists($class)) {
                $gateways[$name] = $gateway;
            }
        }

        ksort($gateways);

        return $gateways;
    }

    /**
     * Create a new gateway instance
     *
     * @param string               $class       Gateway name
     * @throws RuntimeException                 If no such gateway is found
     * @return GatewayInterface                 An object of class $class is created and returned
     */
    public function create($key = null)
    {
        if (!($gateway = $this->getGateway($key))) {
            throw new RuntimeException("Gateway '$key' not found");
        }

        $class = $gateway['gateway'];

        if (!class_exists($class)) {
            throw new RuntimeException("Class '$class' not found");
        }

        $options = $this->settings;

        $options = array_replace($options, $gateway['options']);

        // Create new gateway and attach extra services
        $gateway = new $class($this->logger, $options);

        return $gateway;
    }

    /**
     *
     *
     * @param $key
     *
     * @return bool|mixed
     */
    protected function getGateway($key)
    {
        if ($key === null) {
            return $this->getGateway($this->getDefaultGatewayName());
        }

        if (isset($this->gateways[$key])) {
            return $this->gateways[$key];
        }

        return false;
    }

    /**
     * In case we haven't received a gateway name get the default
     *
     * This is especially useful for single authentication systems
     *
     * @return string
     */
    public function getDefaultGatewayName()
    {
        return $this->settings['default'];
    }
}
