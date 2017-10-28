<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateBlockchainCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('cron:generateBlockchain')
            ->setDescription('Der schwindel blockchain generator');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $start = microtime(true);
        $container = $this->getContainer();

        $container->get('blockchain_generator')->generate();

        $output->writeln('finished');
        $output->writeln('Execution time: '.(microtime(true) - $start) / 60);
    }
}
