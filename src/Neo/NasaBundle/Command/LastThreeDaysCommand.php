<?php
/**
 * Created by PhpStorm.
 * User: Ulukut
 * Date: 2.12.2016
 * Time: 16:11
 *
 * @author Volkan Ulukut <arthan@gmail.com>
 */

namespace Neo\NasaBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class LastThreeDaysCommand
 *
 * Command to persist nasa near earth object data with a 3 day interval.
 *
 * @package Neo\NasaBundle\Command
 */
class LastThreeDaysCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            // the name of the command (the part after "app/console")
            ->setName('neo:last3days')
            // the short description shown while running "php app/console list"
            ->setDescription('request the data from the last 3 days from nasa api and persist in mongo db.')
            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp("This command allows you to request the data from the last 3 days from nasa api and persist in mongo db.");
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln([
            'Persist Last 3 Days',
            '============',
            '',
        ]);

        $api = $this->getContainer()->get('nasa.api');
        //This command should run at the beginning of the day to get 3 whole days of NEO data
        $response = $api->getNEOByDate(date("Y-m-d", strtotime('-3 days')), date("Y-m-d"));
        $repository = $this->getContainer()->get('doctrine_mongodb')->getManager()->getRepository('NasaBundle:Neo');
        foreach ($response->near_earth_objects as $date => $neos) {
            $repository->saveAll($date, $neos);
        }
        $output->writeln(['NEO Count: ' . $response->element_count]);
    }
}