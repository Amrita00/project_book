<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use League\CLImate\CLImate;

class DrawingCommand extends Command
{
    protected static $defaultName = 'app:drawing';
    protected static $defaultDescription = 'Add a short description for your command';

    protected function configure(): void
    {

    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $climate = new CLImate();

        $climate->animation('hello')->enterFrom('right');
        $climate->animation('hello')->enterFrom('left');
        $climate->animation('hello')->enterFrom('top');
        $climate->animation('hello')->enterFrom('bottom');

        $climate->animation('hello')->exitTo('right');
        $climate->animation('hello')->exitTo('left');
        $climate->animation('hello')->exitTo('top');
        $climate->animation('hello')->exitTo('bottom');
        return true;
    }
}
