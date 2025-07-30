# This is console-application-template that can be used to build "Pop Up Applications" when needed. It provides the basic structure including CodeStyle, PHPStan, and Codeception as the testing Framework.

The basic infrastucture is a Symfony Console Application which can be enriched with commands as needed. You can re-use this for single console applications or add more and more console commands to it when you see the need. It's up to you.

This console-application-template makes use of Symfony's DependencyInjection so you don't need to wire everything on your own.

This console-application-template also provides defaults for Claude and makes use of the [PRP Framework](https://github.com/Wirasm/PRPs-agentic-eng).

The application uses a vertical slice architecture.

### Claude

Inside of the .claude/commands/PRPs directory you will find a couple of useful slash commands which are documented on the [PRP Framework](https://github.com/Wirasm/PRPs-agentic-eng).

### Symfony Console

Docs: https://symfony.com/doc/current/components/console.html

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

Use DataTransfer objects as input and output arguments to class methods.


### Testing

Each class must be fully tested with happy cases and unhappy cases.