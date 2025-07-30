<?php

declare(strict_types=1);

namespace App\Shared\Transfer;

class GreetingResponseTransfer extends ResponseTransfer
{
    private ?string $greetingMessage = null;

    public function __construct(
        bool $isSuccessful = false,
        ?string $greetingMessage = null,
        array $errors = []
    ) {
        parent::__construct($isSuccessful, $errors);
        $this->greetingMessage = $greetingMessage;
    }

    public function getGreetingMessage(): ?string
    {
        return $this->greetingMessage;
    }

    public function setGreetingMessage(?string $greetingMessage): self
    {
        $this->greetingMessage = $greetingMessage;
        return $this;
    }
}
