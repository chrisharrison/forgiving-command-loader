<?php

declare(strict_types=1);

namespace ChrisHarrison\ForgivingCommandLoader;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Throwable;

final class PlaceholderCommand extends Command
{
    private $caughtThrowable;
    private $couldNotLoadDescription;

    public function __construct(
        Throwable $caughtThrowable,
        string $couldNotLoadDescription,
        $name = null
    ) {
        $this->caughtThrowable = $caughtThrowable;
        $this->couldNotLoadDescription = $couldNotLoadDescription;
        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this->setDescription($this->couldNotLoadDescription);
    }

    public function execute(InputInterface $input, OutputInterface $output): void
    {
        throw $this->caughtThrowable;
    }
}
