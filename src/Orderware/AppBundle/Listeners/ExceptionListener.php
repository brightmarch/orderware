<?php

namespace Orderware\AppBundle\Listeners;

use Orderware\AppBundle\Library\Services\Responder;

use Symfony\Bridge\Monolog\Logger;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Templating\EngineInterface;

class ExceptionListener
{

    /** @var Symfony\Bridge\Monolog\Logger */
    private $logger;

    /** @var Symfony\Component\Templating\EngineInterface */
    private $templating;

    /** @var SpeedorderApi\AppBundle\Library\Services\Responder */
    private $responder;

    public function __construct(
        Logger $logger,
        EngineInterface $templating,
        Responder $responder
    )
    {
        $this->logger = $logger;
        $this->templating = $templating;
        $this->responder = $responder;
    }

    public function onException(GetResponseForExceptionEvent $event)
    {
        $_ex = $event->getException();

        // Use the URI to determine this is an API
        // request or not as their responses are
        // handled differently.
        $uri = $event->getRequest()
            ->server
            ->get('REQUEST_URI');

        // Log the exception to standard Symfony error logs.
        $this->logger->addError($_ex->getMessage(), [
            'uri' => $uri,
            'file_name' => $_ex->getFile(),
            'line_number' => $_ex->getLine(),
            'exception' => get_class($_ex)
        ]);

        if (0 === stripos($uri, '/api')) {
            if ($_ex instanceof HttpException) {
                // Most likely a valid HTTP status code.
                $statusCode = (int)$_ex->getStatusCode();

                // Not likely to leak information about the application
                // that we wouldn't want leaked anyway.
                $message = $_ex->getMessage();
            } else {
                // Give the exception a chance to still use a
                // valid HTTP status code.
                $statusCode = $_ex->getCode();

                // Message can not be trusted to not leak information -
                // like a failed database query - so end with a generic message.
                $message = "An unrecoverable error occurred during this request and has been logged.";
            }

            // Ensure we have a valid HTTP status code or default to 500.
            if (!isset(Response::$statusTexts[$statusCode])) {
                $statusCode = 500;
            }

            $data = [
                'code' => $statusCode,
                'description' => Response::$statusTexts[$statusCode],
                'message' => $message
            ];

            $response = $this->responder
                ->send('error', $data, $statusCode);

            $event->setResponse($response);
        }

        return true;
    }

}
