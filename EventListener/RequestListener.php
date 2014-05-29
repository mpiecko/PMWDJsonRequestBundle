<?php

namespace PMWD\Bundle\JsonRequestBundle\EventListener;

use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class RequestListener
{

    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();

        if ('json' == $request->getContentType() && in_array($request->getMethod(), array('POST', 'PUT', 'PATCH', 'DELETE'))) {

            $content = $request->getContent();
            if (!empty($content)) {
                $data = json_decode($content, true);
                if (is_array($data)) {
                    $request->request = new ParameterBag($data);
                } else {
                    throw new BadRequestHttpException();
                }
            }

        }

    }
}