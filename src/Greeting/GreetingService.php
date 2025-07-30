<?php

declare(strict_types=1);

namespace App\Greeting;

use App\Shared\Transfer\ErrorTransfer;
use App\Shared\Transfer\GreetingRequestTransfer;
use App\Shared\Transfer\GreetingResponseTransfer;
use Psr\Log\LoggerInterface;

class GreetingService
{
    public function __construct(
        private readonly LoggerInterface $logger
    ) {
    }

    public function greetUser(GreetingRequestTransfer $request): GreetingResponseTransfer
    {
        $name = $request->getName();

        if (empty(trim($name))) {
            $this->logger->warning('Empty name provided for greeting');

            $response = new GreetingResponseTransfer();
            $response->setIsSuccessful(false);
            $response->addError(new ErrorTransfer('Name cannot be empty'));

            return $response;
        }

        $message = "Hello {$name}!";

        $this->logger->info('Generated greeting', [
            'name' => $name,
            'message' => $message
        ]);

        $response = new GreetingResponseTransfer();
        $response->setIsSuccessful(true);
        $response->setGreetingMessage($message);

        return $response;
    }
}
