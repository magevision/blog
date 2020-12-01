<?php
/**
 * MageVision Blog64
 *
 * @category     MageVision
 * @package      MageVision_Blog64
 *
 * @author       MageVision Team
 * @copyright    Copyright (c) 2020 MageVision (https://www.magevision.com)
 * @license      http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
namespace MageVision\Blog64\Console\Command;

use Magento\Directory\Model\ResourceModel\Country\CollectionFactory;
use Magento\Framework\Console\Cli;
use Magento\Framework\Profiler\Driver\Standard\Stat;
use Magento\Framework\Profiler\Driver\Standard\StatFactory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ProfilerCommand extends Command
{
    /**
     * @var StatFactory
     */
    private $statFactory;

    /**
     * @var CollectionFactory
     */
    private $countryCollectionFactory;

    /**
     * @param StatFactory $statFactory
     * @param CollectionFactory $countryCollectionFactory
     * @param string $name
     */
    public function __construct(
        StatFactory $statFactory,
        CollectionFactory $countryCollectionFactory,
        string $name
    ) {
        $this->statFactory = $statFactory;
        $this->countryCollectionFactory = $countryCollectionFactory;

        parent::__construct($name);
    }

    /**
     * @inheritDoc
     */
    protected function configure()
    {
        $this->setDescription('MageVision console command with profiler.');

        parent::configure();
    }

    /**
     * Execute the command
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('<info>Process starts.</info>');

        $stat = $this->statFactory->create();

        $stat->start(
            'magevision_blog64_profiler',
            microtime(true),
            memory_get_usage(true),
            memory_get_usage()
        );

        $countries = $this->countryCollectionFactory->create()->getItems();

        foreach ($countries as $country) {
            // Add here your functionality
            //...
        }

        $stat->stop(
            'magevision_blog64_profiler',
            microtime(true),
            memory_get_usage(true),
            memory_get_usage()
        );

        $stat = $stat->get('magevision_blog64_profiler');
        $stat['time'] = $stat[Stat::TIME];
        $output->writeln([
            '<info>Process successfully finished.</info>',
            sprintf('<info>Executing time in microseconds.: %s</info>', $stat[Stat::TIME]),
            sprintf('<info>Real size of memory allocated from system: %s</info>', $stat[Stat::REALMEM]),
            sprintf('<info>Memory used by emalloc(): %s</info>', $stat[Stat::EMALLOC]),
        ]);

        return Cli::RETURN_SUCCESS;
    }
}
