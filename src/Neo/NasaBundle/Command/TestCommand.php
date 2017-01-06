<?php

namespace Neo\NasaBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Question\ConfirmationQuestion;

/**
 * Class TestCommand
 *
 * Command to check if given neo reference id exists in the database.
 *
 * @package Neo\NasaBundle\Command
 */
class TestCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('test:command')
            ->setDescription('This command checks if a document with an id of the argument exists')
            ->addArgument('id', InputArgument::REQUIRED, 'neo_reference_id of the document.');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $helper = $this->getHelper('question');
        $formatter = $this->getHelper("formatter");
        $question = new ConfirmationQuestion('This is a test. Do you want to continue (y/N) ?', false);
        if (!$helper->ask($input, $output, $question)) {
            $output->writeln($formatter->formatBlock('Nothing done. Exiting...', 'error'));
            return;
        }
        $repository = $this->getContainer()->get('doctrine_mongodb')->getManager()->getRepository('NasaBundle:Neo');
        $result = $repository->findOneBy(["reference" => (int)$input->getArgument('id')]);
        if ($result) {
            $output->writeln($formatter->formatBlock('document exists', 'info'));
        } else {
            $output->writeln($formatter->formatBlock('document doesn\'t exist', 'error'));

        }
    }
}
