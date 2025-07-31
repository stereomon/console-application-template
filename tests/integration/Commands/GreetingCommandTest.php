<?php

declare(strict_types=1);

namespace Tests\Integration\Commands;

use App\Commands\GreetingCommand;
use Codeception\Test\Unit;
use IntegrationTester;
use Symfony\Component\Console\Tester\CommandTester;

class GreetingCommandTest extends Unit
{
    protected IntegrationTester $tester;

    public function testGivenAValidNameWhenIRunTheGreetingCommandThenAGreetingMessageIsDisplayed(): void
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

    public function testGivenAnEmptyNameWhenIRunTheGreetingCommandThenAnErrorMessageIsDisplayed(): void
    {
        // Arrange
        $greetingCommand = $this->tester->get(GreetingCommand::class);
        $commandTester = new CommandTester($greetingCommand);

        // Act
        $exitCode = $commandTester->execute(['name' => '']);

        // Assert
        $this->assertEquals(1, $exitCode);
    }

    public function testGivenAnEmptyNameWhenIRunTheGreetingCommandThenTheErrorMessageIsShown(): void
    {
        // Arrange
        $greetingCommand = $this->tester->get(GreetingCommand::class);
        $commandTester = new CommandTester($greetingCommand);

        // Act
        $commandTester->execute(['name' => '']);

        // Assert
        $this->assertStringContainsString('The following errors occurred:', $commandTester->getDisplay());
    }

    public function testGivenAnEmptyNameWhenIRunTheGreetingCommandThenTheSpecificErrorMessageIsShown(): void
    {
        // Arrange
        $greetingCommand = $this->tester->get(GreetingCommand::class);
        $commandTester = new CommandTester($greetingCommand);

        // Act
        $commandTester->execute(['name' => '']);

        // Assert
        $this->assertStringContainsString('Name cannot be empty', $commandTester->getDisplay());
    }

    public function testGivenAWhitespaceOnlyNameWhenIRunTheGreetingCommandThenAnErrorMessageIsDisplayed(): void
    {
        // Arrange
        $greetingCommand = $this->tester->get(GreetingCommand::class);
        $commandTester = new CommandTester($greetingCommand);

        // Act
        $exitCode = $commandTester->execute(['name' => '   ']);

        // Assert
        $this->assertEquals(1, $exitCode);
    }

    public function testGivenAWhitespaceOnlyNameWhenIRunTheGreetingCommandThenTheEmptyNameErrorIsShown(): void
    {
        // Arrange
        $greetingCommand = $this->tester->get(GreetingCommand::class);
        $commandTester = new CommandTester($greetingCommand);

        // Act
        $commandTester->execute(['name' => '   ']);

        // Assert
        $this->assertStringContainsString('Name cannot be empty', $commandTester->getDisplay());
    }

    public function testGivenANameWithSpecialCharactersWhenIRunTheGreetingCommandThenAGreetingMessageIsDisplayed(): void
    {
        // Arrange
        $greetingCommand = $this->tester->get(GreetingCommand::class);
        $commandTester = new CommandTester($greetingCommand);

        // Act
        $exitCode = $commandTester->execute(['name' => 'José-María']);

        // Assert
        $this->assertEquals(0, $exitCode);
    }

    public function testGivenANameWithSpecialCharactersWhenIRunTheGreetingCommandThenTheCorrectGreetingIsShown(): void
    {
        // Arrange
        $greetingCommand = $this->tester->get(GreetingCommand::class);
        $commandTester = new CommandTester($greetingCommand);

        // Act
        $commandTester->execute(['name' => 'José-María']);

        // Assert
        $this->assertStringContainsString('Hello José-María!', $commandTester->getDisplay());
    }

    public function testGivenAVeryLongNameWhenIRunTheGreetingCommandThenAGreetingMessageIsDisplayed(): void
    {
        // Arrange
        $greetingCommand = $this->tester->get(GreetingCommand::class);
        $commandTester = new CommandTester($greetingCommand);
        $longName = str_repeat('A', 100);

        // Act
        $exitCode = $commandTester->execute(['name' => $longName]);

        // Assert
        $this->assertEquals(0, $exitCode);
    }

    public function testGivenAVeryLongNameWhenIRunTheGreetingCommandThenTheCorrectGreetingIsShown(): void
    {
        // Arrange
        $greetingCommand = $this->tester->get(GreetingCommand::class);
        $commandTester = new CommandTester($greetingCommand);
        $longName = str_repeat('A', 100);

        // Act
        $commandTester->execute(['name' => $longName]);

        // Assert
        $this->assertStringContainsString("Hello {$longName}!", $commandTester->getDisplay());
    }

    public function testGivenANameWithNumbersWhenIRunTheGreetingCommandThenAGreetingMessageIsDisplayed(): void
    {
        // Arrange
        $greetingCommand = $this->tester->get(GreetingCommand::class);
        $commandTester = new CommandTester($greetingCommand);

        // Act
        $exitCode = $commandTester->execute(['name' => 'John123']);

        // Assert
        $this->assertEquals(0, $exitCode);
    }

    public function testGivenANameWithNumbersWhenIRunTheGreetingCommandThenTheCorrectGreetingIsShown(): void
    {
        // Arrange
        $greetingCommand = $this->tester->get(GreetingCommand::class);
        $commandTester = new CommandTester($greetingCommand);

        // Act
        $commandTester->execute(['name' => 'John123']);

        // Assert
        $this->assertStringContainsString('Hello John123!', $commandTester->getDisplay());
    }

    public function testGivenANameWithTabsAndSpacesWhenIRunTheGreetingCommandThenAnErrorIsDisplayed(): void
    {
        // Arrange
        $greetingCommand = $this->tester->get(GreetingCommand::class);
        $commandTester = new CommandTester($greetingCommand);

        // Act
        $exitCode = $commandTester->execute(['name' => "\t\n  \r"]);

        // Assert
        $this->assertEquals(1, $exitCode);
    }

    public function testGivenANameWithTabsAndSpacesWhenIRunTheGreetingCommandThenTheEmptyNameErrorIsShown(): void
    {
        // Arrange
        $greetingCommand = $this->tester->get(GreetingCommand::class);
        $commandTester = new CommandTester($greetingCommand);

        // Act
        $commandTester->execute(['name' => "\t\n  \r"]);

        // Assert
        $this->assertStringContainsString('Name cannot be empty', $commandTester->getDisplay());
    }

    public function testGivenANameWithLeadingAndTrailingSpacesWhenIRunTheGreetingCommandThenAGreetingIsDisplayed(): void
    {
        // Arrange
        $greetingCommand = $this->tester->get(GreetingCommand::class);
        $commandTester = new CommandTester($greetingCommand);

        // Act
        $exitCode = $commandTester->execute(['name' => '  John  ']);

        // Assert
        $this->assertEquals(0, $exitCode);
    }

    public function testGivenANameWithLeadingTrailingSpacesWhenIRunCommandThenCorrectGreetingIsShown(): void
    {
        // Arrange
        $greetingCommand = $this->tester->get(GreetingCommand::class);
        $commandTester = new CommandTester($greetingCommand);

        // Act
        $commandTester->execute(['name' => '  John  ']);

        // Assert
        $this->assertStringContainsString('Hello   John  !', $commandTester->getDisplay());
    }

    public function testGivenANameWithUnicodeCharactersWhenIRunTheGreetingCommandThenAGreetingIsDisplayed(): void
    {
        // Arrange
        $greetingCommand = $this->tester->get(GreetingCommand::class);
        $commandTester = new CommandTester($greetingCommand);

        // Act
        $exitCode = $commandTester->execute(['name' => '田中太郎']);

        // Assert
        $this->assertEquals(0, $exitCode);
    }

    public function testGivenANameWithUnicodeCharactersWhenIRunTheGreetingCommandThenTheCorrectGreetingIsShown(): void
    {
        // Arrange
        $greetingCommand = $this->tester->get(GreetingCommand::class);
        $commandTester = new CommandTester($greetingCommand);

        // Act
        $commandTester->execute(['name' => '田中太郎']);

        // Assert
        $this->assertStringContainsString('Hello 田中太郎!', $commandTester->getDisplay());
    }

    public function testGivenANameWithEmojiWhenIRunTheGreetingCommandThenAGreetingIsDisplayed(): void
    {
        // Arrange
        $greetingCommand = $this->tester->get(GreetingCommand::class);
        $commandTester = new CommandTester($greetingCommand);

        // Act
        $exitCode = $commandTester->execute(['name' => 'John😊']);

        // Assert
        $this->assertEquals(0, $exitCode);
    }

    public function testGivenANameWithEmojiWhenIRunTheGreetingCommandThenTheCorrectGreetingIsShown(): void
    {
        // Arrange
        $greetingCommand = $this->tester->get(GreetingCommand::class);
        $commandTester = new CommandTester($greetingCommand);

        // Act
        $commandTester->execute(['name' => 'John😊']);

        // Assert
        $this->assertStringContainsString('Hello John😊!', $commandTester->getDisplay());
    }
}
