<?php

namespace Labs\MembersBundle\EventListener;

use FOS\UserBundle\Model\User;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Security\Core\Authentication\Token\AnonymousToken;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class UserLoginRouteListener
{
    /**
     * @var TokenStorageInterface
     */
    private $tokenStorageInterface;
    /**
     * @var RouterInterface
     */
    private $routerInterface;

    public function __construct(TokenStorageInterface $tokenStorageInterface, RouterInterface $routerInterface, ContainerInterface $container)
    {
        $this->tokenStorageInterface = $tokenStorageInterface;
        $this->routerInterface = $routerInterface;
        $this->securityContext = $container->get('security.token_storage');
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();

        if ($request->get('_route') == 'fos_user_security_login') {
            if(is_object($this->securityContext->getToken()->getUser())){
                $event->setResponse(new RedirectResponse($this->routerInterface->generate('labs_facturation_homepage')));
            }
        }

        if ($this->tokenStorageInterface->getToken() === null) {
            return false;
        }

        if ($this->tokenStorageInterface->getToken() instanceof AnonymousToken) {
            return false;
        }

       /* if ($this->tokenStorageInterface->getToken()->getUser() instanceof User) {
            return $event->setResponse(new RedirectResponse($this->routerInterface->generate('labs_front_homepage')));
        }*/

    }
}