<?php

declare(strict_types=1);

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:fib-num',
    description: 'Add a short description for your command',
)]
class FibNumCommand extends Command
{

    protected function configure(): void
    {
        $this
            ->addArgument('limit', InputArgument::REQUIRED, 'Fibonacci number limit')
            ->setDescription('Output fibonacci numbers')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $limit = $input->getArgument('limit');
        
        $fib = [0, 1];
        for($i = 0; $i < $limit; $i++) {
            $fib[] = $fib[$i] + $fib[$i + 1];
            $output->writeln(next($fib));
            sleep(5);
        }

        return Command::SUCCESS;
    }
}
