<?php
namespace RmAuthenticatorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class AuthenticateController extends AbstractController
{
    public function index(Request $request)
    {
        return $this->render('@RmAuthenticatorBundle/index.html.twig');
    }
}
