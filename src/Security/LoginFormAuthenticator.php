<?php

namespace App\Security;

use App\Repository\PersonaRepository;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\InvalidCsrfTokenException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Security\Csrf\isTokenValid;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;

class LoginFormAuthenticator extends AbstractGuardAuthenticator
{

    private $userRepository;
    private $router;
    private $csrfTokenManager;

    public function __construct(PersonaRepository $userRepository, RouterInterface $router, CsrfTokenManagerInterface $csrfTokenManager)
    {
        $this->userRepository   = $userRepository;
        $this->router           = $router;
        $this->csrfTokenManager = $csrfTokenManager;
    }

    public function supports(Request $request)
    {
        // todo

        return $request->attributes->get('_route') === 'app_login'
        && $request->isMethod('POST');
    }

    public function getCredentials(Request $request)
    {

        // dump($request->request->all());die;
        // dd($request->request->all());
        // todo

        $credentials = [
            'email'      => $request->request->get('email'),
            'password'   => $request->request->get('password'),
            'csrf_token' => $request->request->get('_csrf_token'),
        ];
        if ($request->hasSession()) {
            $request->getSession()->set(Security::LAST_USERNAME,
                $credentials['email']);
        };
        return $credentials;

    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        //dd($userProvider);
        $token = new CsrfToken('authenticate_gustavo', $credentials['csrf_token']);
        if (!$this->csrfTokenManager->isTokenValid($token)) {
            throw new InvalidCsrfTokenException();
        }
        return $this->userRepository->findOneBy(['nombre' => $credentials['email']]);

    }

    public function checkCredentials($credentials, UserInterface $user)
    {

        // todo
        // dd($user);
        // only needed if we need to check a password - we'll do that later!
        return true;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        // dd('NO APARECES!');

        // return null;

        // return new JsonResponse(['result' => $exception->getMessage()], 401);
        //  return new JsonResponse(['result' => $exception->getMessage()], 401);

        // dd($request, $exception);
        //<div>{{ error.messageKey|trans(error.messageData, 'security') }}</div>
        $error = [
            // you may want to customize or obfuscate the message first
            'messageKey' => strtr($exception->getMessageKey(), $exception->getMessageData()),

            // or to translate this message
            // $this->translator->trans($exception->getMessageKey(), $exception->getMessageData())
        ];

        /*   $error = ['error' => ['messageKey' => $exception->getMessageKey(),
        'messageData'

        => $exception->getMessageData()]];*/

        if ($request->hasSession()) {
            $request->getSession()->set(Security::AUTHENTICATION_ERROR,
                $exception);
        };

        //return new JsonResponse($error, Response::HTTP_UNAUTHORIZED);
        //return new JsonResponse($error, Response::HTTP_UNAUTHORIZED);

        return new RedirectResponse($this->router->generate('app_login'));

    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        //dd('success!');
        //
        //dd('app.Username');
        return new RedirectResponse($this->router->generate('persona_admin'));
        //dd($this->router);
    }

    public function start(Request $request, AuthenticationException $authException = null)
    {

    }

    public function supportsRememberMe()
    {
        // todo
    }

    protected function getLoginUrl()
    {

        return $this->router->generate('app_login');

    }
}
