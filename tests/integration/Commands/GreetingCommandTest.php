<?php

declare(strict_types=1);

namespace Tests\Integration\Commands;

use App\Commands\GreetingCommand;
use Codeception\Test\Unit;
use IntegrationTester;

class GreetingCommandTest extends Unit
{
    protected IntegrationTester $tester;

    public function testGivenAValidNameWhenIRunTheGreetingCommandThenAGreetingMessageIsDisplayed(): void
    {
        // Arrange
        $greetingCommandTester = $this->tester->getCommandTester(GreetingCommand::class);

        // Act
        $greetingCommandTester->execute(['name' => 'John']);

        // Assert
        $this->assertStringContainsString('Hello John!', $greetingCommandTester->getDisplay());
    }

    public function testGivenAnEmptyNameWhenIRunTheGreetingCommandThenTheErrorMessageIsShown(): void
    {
        // Arrange
        $greetingCommandTester = $this->tester->getCommandTester(GreetingCommand::class);

        // Act
        $greetingCommandTester->execute(['name' => '']);

        // Assert
        $this->assertStringContainsString('The following errors occurred:', $greetingCommandTester->getDisplay());
    }

    public function testGivenAnEmptyNameWhenIRunTheGreetingCommandThenTheSpecificErrorMessageIsShown(): void
    {
        // Arrange
        $greetingCommandTester = $this->tester->getCommandTester(GreetingCommand::class);

        // Act
        $greetingCommandTester->execute(['name' => '']);

        // Assert
        $this->assertStringContainsString('Name cannot be empty', $greetingCommandTester->getDisplay());
    }

    public function testGivenAWhitespaceOnlyNameWhenIRunTheGreetingCommandThenTheEmptyNameErrorIsShown(): void
    {
        // Arrange
        $greetingCommandTester = $this->tester->getCommandTester(GreetingCommand::class);

        // Act
        $greetingCommandTester->execute(['name' => '   ']);

        // Assert
        $this->assertStringContainsString('Name cannot be empty', $greetingCommandTester->getDisplay());
    }

    public function testGivenANameWithSpecialCharactersWhenIRunTheGreetingCommandThenTheCorrectGreetingIsShown(): void
    {
        // Arrange
        $greetingCommandTester = $this->tester->getCommandTester(GreetingCommand::class);

        // Act
        $greetingCommandTester->execute(['name' => 'José-María']);

        // Assert
        $this->assertStringContainsString('Hello José-María!', $greetingCommandTester->getDisplay());
    }

    public function testGivenAVeryLongNameWhenIRunTheGreetingCommandThenTheCorrectGreetingIsShown(): void
    {
        // Arrange
        $greetingCommandTester = $this->tester->getCommandTester(GreetingCommand::class);
        $longName = str_repeat('A', 100);

        // Act
        $greetingCommandTester->execute(['name' => $longName]);

        // Assert
        $this->assertStringContainsString("Hello {$longName}!", $greetingCommandTester->getDisplay());
    }

    public function testGivenANameWithNumbersWhenIRunTheGreetingCommandThenTheCorrectGreetingIsShown(): void
    {
        // Arrange
        $greetingCommandTester = $this->tester->getCommandTester(GreetingCommand::class);

        // Act
        $greetingCommandTester->execute(['name' => 'John123']);

        // Assert
        $this->assertStringContainsString('Hello John123!', $greetingCommandTester->getDisplay());
    }

    public function testGivenANameWithTabsAndSpacesWhenIRunTheGreetingCommandThenTheEmptyNameErrorIsShown(): void
    {
        // Arrange
        $greetingCommandTester = $this->tester->getCommandTester(GreetingCommand::class);

        // Act
        $greetingCommandTester->execute(['name' => "\t\n  \r"]);

        // Assert
        $this->assertStringContainsString('Name cannot be empty', $greetingCommandTester->getDisplay());
    }

    public function testGivenANameWithLeadingTrailingSpacesWhenIRunCommandThenCorrectGreetingIsShown(): void
    {
        // Arrange
        $greetingCommandTester = $this->tester->getCommandTester(GreetingCommand::class);

        // Act
        $greetingCommandTester->execute(['name' => '  John  ']);

        // Assert
        $this->assertStringContainsString('Hello   John  !', $greetingCommandTester->getDisplay());
    }

    public function testGivenANameWithUnicodeCharactersWhenIRunTheGreetingCommandThenTheCorrectGreetingIsShown(): void
    {
        // Arrange
        $greetingCommandTester = $this->tester->getCommandTester(GreetingCommand::class);

        // Act
        $greetingCommandTester->execute(['name' => '田中太郎']);

        // Assert
        $this->assertStringContainsString('Hello 田中太郎!', $greetingCommandTester->getDisplay());
    }

    public function testGivenANameWithEmojiWhenIRunTheGreetingCommandThenTheCorrectGreetingIsShown(): void
    {
        // Arrange
        $greetingCommandTester = $this->tester->getCommandTester(GreetingCommand::class);

        // Act
        $greetingCommandTester->execute(['name' => 'John😊']);

        // Assert
        $this->assertStringContainsString('Hello John😊!', $greetingCommandTester->getDisplay());
    }
}
