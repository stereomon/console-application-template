<?php

declare(strict_types=1);

namespace Tests\Unit\Greeting;

use App\Greeting\GreetingService;
use App\Shared\Transfer\GreetingRequestTransfer;
use Codeception\Test\Unit;
use Psr\Log\LoggerInterface;

class GreetingServiceTest extends Unit
{
    public function testGreetUserWithValidNameReturnsSuccessfulResponse(): void
    {
        // Arrange
        $logger = $this->createMock(LoggerInterface::class);
        $service = new GreetingService($logger);
        $request = new GreetingRequestTransfer('John');

        // Act
        $response = $service->greetUser($request);

        // Assert
        $this->assertTrue($response->isSuccessful());
        $this->assertEquals('Hello John!', $response->getGreetingMessage());
    }

    public function testGreetUserWithEmptyNameReturnsFailedResponse(): void
    {
        // Arrange
        $logger = $this->createMock(LoggerInterface::class);
        $logger->expects($this->once())
            ->method('warning')
            ->with('Empty name provided for greeting');

        $service = new GreetingService($logger);
        $request = new GreetingRequestTransfer('');

        // Act
        $response = $service->greetUser($request);

        // Assert
        $this->assertFalse($response->isSuccessful());
    }

    public function testGreetUserWithWhitespaceOnlyNameReturnsFailedResponse(): void
    {
        // Arrange
        $logger = $this->createMock(LoggerInterface::class);
        $service = new GreetingService($logger);
        $request = new GreetingRequestTransfer('   ');

        // Act
        $response = $service->greetUser($request);

        // Assert
        $this->assertFalse($response->isSuccessful());
        $this->assertCount(1, $response->getErrors());
        $this->assertEquals('Name cannot be empty', $response->getErrors()[0]->getMessage());
    }

    public function testGreetUserLogsSuccessfulGreeting(): void
    {
        // Arrange
        $logger = $this->createMock(LoggerInterface::class);
        $logger->expects($this->once())
            ->method('info')
            ->with('Generated greeting', [
                'name' => 'Alice',
                'message' => 'Hello Alice!'
            ]);

        $service = new GreetingService($logger);
        $request = new GreetingRequestTransfer('Alice');

        // Act
        $service->greetUser($request);

        // Assert - expectations are verified automatically
    }
}
