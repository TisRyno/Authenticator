<?php
namespace RmAuthenticatorBundle\Authenticator\Common;

interface GatewayInterface
{
    /**
     * Initial setup of Gateway specific connections to 3rd party services
     *
     * @return mixed
     */
    function createConnection();
}
