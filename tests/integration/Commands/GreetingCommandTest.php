<?php

declare(strict_types=1);

namespace Tests\Integration\Commands;

use App\Commands\GreetingCommand;
use App\Kernel;
use Codeception\Test\Unit;
use IntegrationTester;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;

class GreetingCommandTest extends Unit
{
    protected IntegrationTester $tester;


    public function testGivenAValidNameWhenIRunTheGreetingCommandThenAgreetingMessageIsDisplayed(): void
    {
        // Arrange
        $greetingCommand = $this->tester->get(GreetingCommand::class);
        $commandTester = new CommandTester($greetingCommand);

        // Act
        $exitCode = $commandTester->execute(['name' => 'John']);

        // Assert
        $this->assertEquals(0, $exitCode);
        $this->assertStringContainsString('Hello John!', $commandTester->getDisplay());
    }

    public function testGreetingCommandWithEmptyNameShowsError(): void
    {
        // Arrange
        $greetingCommand = $this->tester->get(GreetingCommand::class);
        $commandTester = new CommandTester($greetingCommand);

        // Act
        $exitCode = $commandTester->execute(['name' => '']);

        // Assert
        $this->assertEquals(1, $exitCode);
        $this->assertStringContainsString('The following errors occurred:', $commandTester->getDisplay());
        $this->assertStringContainsString('Name cannot be empty', $commandTester->getDisplay());
    }

    public function testGreetingCommandWithWhitespaceNameShowsError(): void
    {
        // Arrange
        $greetingCommand = $this->tester->get(GreetingCommand::class);
        $commandTester = new CommandTester($greetingCommand);

        // Act
        $exitCode = $commandTester->execute(['name' => '   ']);

        // Assert
        $this->assertEquals(1, $exitCode);
        $this->assertStringContainsString('Name cannot be empty', $commandTester->getDisplay());
    }
}
