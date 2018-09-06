<?php

// @codingStandardsIgnoreFile

declare(strict_types=1);

namespace ChrisHarrison\ForgivingCommandLoader;

use Exception;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class PlaceholderCommandTest extends TestCase
{
    public function test_it_has_the_correct_name()
    {
        $placeholder = new PlaceholderCommand(
            new _TestException,
            'Test description',
            'test:command'
        );

        $this->assertEquals('test:command', $placeholder->getName());
    }

    public function test_it_has_the_correct_description()
    {
        $placeholder = new PlaceholderCommand(
            new _TestException,
            'Test description',
            'test:command'
        );

        $this->assertEquals('Test description', $placeholder->getDescription());
    }

    public function test_when_it_is_executed_the_throwable_which_it_was_instantiated_with_is_thrown()
    {
        $input = $this->prophesize(InputInterface::class);
        $output = $this->prophesize(OutputInterface::class);

        $placeholder = new PlaceholderCommand(
            new _TestException,
            'Test description',
            'test:command'
        );

        $this->expectException(_TestException::class);
        $placeholder->execute($input->reveal(), $output->reveal());
    }
}

final class _TestException extends Exception
{
    public function __construct()
    {
        parent::__construct('Test exception');
    }
}