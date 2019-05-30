<?php
namespace RmAuthenticatorBundle\Controller;

use RmAuthenticatorBundle\Authenticator\Factory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class AuthenticateController extends AbstractController
{
    public function index(Request $request, Factory $factory)
    {
        $request->request->get('gateway');

        $facebookFactory = $factory->create('Facebook');

        $twitterFactory = $factory->create('Twitter');

        $gitHubFactory = $factory->create('GitHub');

        return $this->render('@RmAuthenticatorBundle/index.html.twig', [
            'facebookSupport' => $facebookFactory->supportsFetchUserData(),
            'twitterSupport' => $twitterFactory->supportsFetchUserData(),
            'gitHubSupport' => $gitHubFactory->supportsFetchUserData(),
        ]);
    }
}
