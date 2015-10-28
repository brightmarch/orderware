<?php

namespace Orderware\AppBundle\Listeners;

use Orderware\AppBundle\Controller\ApiControllerInterface;
use Orderware\AppBundle\Entity\Request;
use Orderware\AppBundle\Library\Services\RequestValidator;

use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;

use Doctrine\ORM\EntityManager;

use Ramsey\Uuid\Uuid;

class RequestListener
{

    /* @var Doctrine\ORM\EntityManager */
    private $entityManager;

    /** @const string */
    const AUTHOR = 'request_listener';

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function onRequest(FilterControllerEvent $event)
    {
        $controller = $event->getController()[0];

        if ($controller instanceof ApiControllerInterface) {
            // Log the request in the database.
            $user = $controller->getUser();
            $requestId = Uuid::uuid4()->toString();

            $request = new Request;
            $request->setDivision($user->getDivision())
                ->setUser($controller->getUser())
                ->setCreatedBy(self::AUTHOR)
                ->setUpdatedBy(self::AUTHOR)
                ->setRequestId($requestId)
                ->copyRequest($event->getRequest())
                ->startTimer();

            $_em = $this->entityManager;
            $_em->persist($request);
            $_em->flush();

            // For easy reference in the controller.
            $event->getRequest()
                ->attributes
                ->set('request_id', $requestId);
        }

        return true;
    }

    public function onResponse(FilterResponseEvent $event)
    {
        $requestId = $event->getRequest()
            ->attributes
            ->get('request_id');

        if ($requestId) {
            $request = $this->entityManager
                ->getRepository('Orderware:Request')
                ->findOneByRequestId($requestId);

            if ($request) {
                $request->copyResponse(
                    $event->getResponse()
                )->stopTimer();

                $_em = $this->entityManager;
                $_em->persist($request);
                $_em->flush();
            }
        }

        return true;
    }

}
