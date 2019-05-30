<?php
namespace RmAuthenticatorBundle\Controller;

use RmAuthenticatorBundle\Authenticator\Factory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class AuthenticateController extends AbstractController
{
    public function index(Request $request, Factory $factory)
    {
        dump($factory);

        return $this->render('@RmAuthenticatorBundle/index.html.twig');
    }
}
