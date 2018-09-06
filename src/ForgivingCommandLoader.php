<?php

declare(strict_types=1);

namespace ChrisHarrison\ForgivingCommandLoader;

use Symfony\Component\Console\CommandLoader\CommandLoaderInterface;
use Throwable;

final class ForgivingCommandLoader implements CommandLoaderInterface
{
    private $commandLoader;
    private $couldNotLoadDescription;

    public function __construct(
        CommandLoaderInterface $commandLoader,
        ?string $couldNotLoadDescription = null
    ) {
        $this->commandLoader = $commandLoader;

        if ($couldNotLoadDescription !== null) {
            $this->couldNotLoadDescription = $couldNotLoadDescription;
        } else {
            $this->couldNotLoadDescription = '** Could not load';
        }
    }

    public function get($name)
    {
        try {
            return $this->commandLoader->get($name);
        } catch (Throwable $e) {
            return new PlaceholderCommand($e, $this->couldNotLoadDescription, $name);
        }
    }

    public function has($name)
    {
        try {
            return $this->commandLoader->has($name);
        } catch (Throwable $e) {
            return true;
        }
    }

    public function getNames()
    {
        return $this->commandLoader->getNames();
    }
}
