<?php

declare(strict_types=1);

namespace App;

use App\Greeting\GreetingService;
use App\Shared\Transfer\GreetingRequestTransfer;
use App\Shared\Transfer\GreetingResponseTransfer;
use Psr\Log\LoggerInterface;

/**
 * Main application facade providing access to all vertical slice functionality.
 * This is the only facade in the application - do not create separate facades for vertical slices.
 */
class AppFacade
{
    public function __construct(
        private readonly LoggerInterface $logger,
        private readonly GreetingService $greetingService
    ) {
    }

    public function getLogger(): LoggerInterface
    {
        return $this->logger;
    }

    public function greetUser(GreetingRequestTransfer $request): GreetingResponseTransfer
    {
        return $this->greetingService->greetUser($request);
    }
}
