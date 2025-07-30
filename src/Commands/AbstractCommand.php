<?php

declare(strict_types=1);

namespace App\Commands;

use App\Shared\Transfer\ErrorTransfer;
use App\Shared\Transfer\ResponseTransfer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;

abstract class AbstractCommand extends Command
{
    public const int SUCCESS = Command::SUCCESS;
    public const int FAILURE = Command::FAILURE;

    protected function handleResponse(ResponseTransfer $response, SymfonyStyle $io): int
    {
        if (!$response->isSuccessful()) {
            $this->displayErrors($response->getErrors(), $io);
            return self::FAILURE;
        }

        return self::SUCCESS;
    }

    /**
     * @param ErrorTransfer[] $errors
     */
    private function displayErrors(array $errors, SymfonyStyle $io): void
    {
        $io->error('The following errors occurred:');

        foreach ($errors as $error) {
            $io->writeln('• ' . $error->getMessage());
        }
    }
}
