<?php

declare(strict_types=1);

namespace App;

use App\Commands\GreetingCommand;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    public function getConsoleApplication(): Application
    {
        $this->boot();
        $application = new Application('Console Application Template', '1.0.0');

        // Add commands manually for now
        $greetingCommand = $this->getContainer()->get(GreetingCommand::class);
        if ($greetingCommand instanceof Command) {
            $application->add($greetingCommand);
        }

        return $application;
    }

    /**
     * @phpstan-ignore-next-line
     */
    private function configureContainer(ContainerConfigurator $container): void
    {
        $configDir = $this->getConfigDir();

        $container->import($configDir . '/services.php');

        if ($this->environment === 'test') {
            $container->import($configDir . '/services_test.php');
        }
    }

    /**
     * @phpstan-ignore-next-line
     */
    private function configureRoutes(RoutingConfigurator $routes): void
    {
        // No routes needed for console application
    }
}
