<?php

// @codingStandardsIgnoreFile

declare(strict_types=1);

namespace ChrisHarrison\ForgivingCommandLoader;

use Exception;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Symfony\Component\Console\CommandLoader\CommandLoaderInterface;

final class ForgivingCommandLoaderTest extends TestCase
{
    public function test_can_get_instantiable_command_from_loader()
    {
        $loader = $this->prophesize(CommandLoaderInterface::class);
        $loader->get(Argument::any())->willReturn('command');

        $forgivingLoader = new ForgivingCommandLoader($loader->reveal());
        $this->assertEquals('command', $forgivingLoader->get('any'));
    }

    public function test_when_getting_a_command_from_the_loader_if_an_error_occurs_a_placeholder_is_returned()
    {
        $loader = $this->prophesize(CommandLoaderInterface::class);
        $loader->get(Argument::any())->will(function () {
            throw new Exception;
        });

        $forgivingLoader = new ForgivingCommandLoader($loader->reveal());
        $this->assertInstanceOf(PlaceholderCommand::class, $forgivingLoader->get('any'));
    }

    public function test_if_a_command_is_not_in_the_loader_the_has_method_returns_false()
    {
        $loader = $this->prophesize(CommandLoaderInterface::class);
        $loader->has(Argument::any())->willReturn(false);

        $forgivingLoader = new ForgivingCommandLoader($loader->reveal());
        $this->assertFalse($forgivingLoader->has('any'));
    }

    public function test_if_a_command_is_in_the_loader_and_is_instantiable_without_errors_the_has_method_returns_true()
    {
        $loader = $this->prophesize(CommandLoaderInterface::class);
        $loader->has(Argument::any())->willReturn(true);

        $forgivingLoader = new ForgivingCommandLoader($loader->reveal());
        $this->assertTrue($forgivingLoader->has('any'));
    }

    public function test_if_a_command_is_in_the_loader_and_is_not_instantiable_without_errors_the_has_method_returns_true()
    {
        $loader = $this->prophesize(CommandLoaderInterface::class);
        $loader->has(Argument::any())->will(function () {
            throw new Exception;
        });

        $forgivingLoader = new ForgivingCommandLoader($loader->reveal());
        $this->assertTrue($forgivingLoader->has('any'));
    }

    public function test_get_names_method_returns_list_from_underlying_command_loader()
    {
        $loader = $this->prophesize(CommandLoaderInterface::class);
        $loader->getNames()->willReturn('names');

        $forgivingLoader = new ForgivingCommandLoader($loader->reveal());
        $this->assertEquals('names', $forgivingLoader->getNames());
    }
}
