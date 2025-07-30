# This is console-application-template that can be used to build "Pop Up Applications" when needed. It provides the basic structure including CodeStyle, PHPStan, and Codeception as the testing Framework.

The basic infrastucture is a Symfony Console Application which can be enriched with commands as needed. You can re-use this for single console applications or add more and more console commands to it when you see the need. It's up to you.

This console-application-template makes use of Symfony's DependencyInjection so you don't need to wire everything on your own.

This console-application-template also provides defaults for Claude and makes use of the [PRP Framework](https://github.com/Wirasm/PRPs-agentic-eng).

The application uses a vertical slice architecture.

### Claude

Inside of the .claude/commands/PRPs directory you will find a couple of useful slash commands which are documented on the [PRP Framework](https://github.com/Wirasm/PRPs-agentic-eng).

### Symfony basics
- Use ethe MicroKernel.
- Use the Runtime component.
- Provide configurations for development and testing.
    - All dependenciees need to be public in test mode.

### Symfony Console

Docs: https://symfony.com/doc/current/components/console.html

- Provide an abstract class that has SUCCESS and FAILURE constants taht I can use to return in my console command.
- Check the DTO for success and if not successful print out error messages to the user so he can act accordingly.

### Symfony Dependency Injection

Docs: https://symfony.com/doc/current/components/dependency_injection.html

### Codeception

Docs: Getting started Guide https://codeception.com/docs/GettingStarted

Foxus will be on Unit and Integration tests.

### PHPStan

Docs: Getting started Guide https://phpstan.org/user-guide/getting-started

### Code Style Sniffer

GitHub README.md: https://github.com/squizlabs/PHP_CodeSniffer

## The basic architecture of this application

|- src/ - Contains all source files
|---- Commands - Contains all Console commands this application will provide
|---- [Name of a vertical slice e.g. Customer]
|-------- All to this vertical slice related files
|- tests/ - Contains all test files and follows the default Codeception structure

### SOLID

Follows the SOLID principles which are
- Single Responsibility
- Open / Closed
- Liskov Substitution
- Interface segregation
- Dependency Inversion

### Data Transfer Objects

- Use DataTransfer objects as input and output arguments to class methods.
- Objects must be suffixed with Transfer, do not use DTO.
- Output DTOs must have a isSuccessful property that I can use to check if a process was succesful or not.
- When a process is not successful the response DTO should also contain an array of ErrorTransfers that I can use.


### Testing

- Each class must be fully tested with happy cases and unhappy cases.
- Try adding Integration tests over Unit tests, we only want to cover a full path of execution through it s public facing entry point.
- Only add Unit tests when a test setup is too complex to be done as Integration test.
- Use Given When Then Syntax for testing.
- Use a Console Helper (Codeception Module) that uses the Symfony Console Tester and include this helper as Codeception Module into the test types configurations.
- Make each class of a vertical slice public in the container for testing mode.
- Try avoid using setUp or _before methods and setup each test case on its own.
- Add a Symfony Helper (Codeception Module) that has access to the container so I can get the dependencyies I neeed for testing out of the container without using "new" and include this helper as Codeception Module into the test types configurations.
    - This helper must also have a set method to be able to use Mocks and using them when a dependcy of it is required in one of the classes under test.
- Use the // Arrange // Act // Assert way of wrinting each test case.
- Only ever use one assertion per test and it another test if needed.
- Use "protected [type hint to the tester class] $tester;" and use this when getting objects to test from the container

### Exceptions
- Try to avoid exceptions and let the code always return a proper and helpful response to fix an issue.

### Logging
- Provide a logging mechanis that makes use of Monolog and gets injected where needed.

### Quality assurance

Provide composer scripts as following

- phpstan; to run PHPStan.
- cs-check; to check Code Style issues.
- cs-fix; to fix Code Style issues.
- test; to run codeception tests.
- local-ci; to run all QA scripts.
- Alweays ensure that every change is fully compatible and has no issues.