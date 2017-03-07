<?php

namespace AppBundle\EventListener;

use AppBundle\Exception\RedirectException;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;

use JMS\DiExtraBundle\Annotation\Service;
use JMS\DiExtraBundle\Annotation\Tag;

/**
 * @Service("app.redirect_exception_listener")
 * @Tag("kernel.event_listener", attributes = {"event" = "kernel.exception"})
 */
class RedirectExceptionListener
{
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        if($event->getException() instanceof RedirectException){
            $event->setResponse($event->getException()->getRedirectResponse());
        }
    }
}
