<?php
/**
 * MageVision Blog92
 *
 * @category     MageVision
 * @package      MageVision_Blog92
 * @author       MageVision Team
 * @copyright    Copyright (c) 2024 MageVision (https://www.magevision.com)
 * @license      http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
declare(strict_types=1);

namespace MageVision\Blog92\Console\Command;

use Exception;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\App\Area;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\App\State;
use Magento\Framework\Console\Cli;
use Magento\Framework\Exception\FileSystemException;
use Magento\Framework\Filesystem\Driver\File;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Magento\Framework\File\Csv;

class ExportCommand extends Command
{
    private State $state;

    private DirectoryList $directoryList;

    private Csv $csv;

    private CustomerRepositoryInterface $customerRepository;

    private File $file;

    private SearchCriteriaBuilder $searchCriteriaBuilder;

    public function __construct(
        State $state,
        DirectoryList $directoryList,
        Csv $csv,
        CustomerRepositoryInterface $customerRepository,
        File $file,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        string $name
    ) {
        parent::__construct();
        $this->state = $state;
        $this->directoryList = $directoryList;
        $this->csv = $csv;
        $this->customerRepository = $customerRepository;
        $this->file = $file;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;

        parent::__construct($name);
    }

    /**
     * @return void
     */
    protected function configure()
    {
        $this->setDescription('Export Customer Data to CSV');

        parent::configure();
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('<info>Export starts.</info>');

        try {
            $this->state->setAreaCode(Area::AREA_ADMINHTML);
        } catch (Exception $e) {
            /* Do nothing, it's OK */
        }

        try {
            $searchCriteria = $this->searchCriteriaBuilder->create();
            $customers = $this->customerRepository->getList($searchCriteria)->getItems();

            $this->exportDataCsvFile($customers);

            $output->write(PHP_EOL);
            $output->writeln('<info>CSV file successfully exported!</info>');

        } catch (Exception $e) {
            $output->writeln('<error>' . $e->getMessage() . '</error>');
        }

        return Cli::RETURN_SUCCESS;
    }

    /**
     * @param $customers
     * @return void
     * @throws FileSystemException
     */
    private function exportDataCsvFile($customers)
    {
        $exportData = [];
        $exportData[] = $this->getCsvHeaders();
        if (count($customers) > 0) {
            foreach ($customers as $customer) {
                $exportData[] = [
                    $customer->getFirstname(),
                    $customer->getLastName(),
                    $customer->getEmail()
                ];
            }

            $date = (new \DateTime())->format('Ymd_His');
            $filename = 'customer_data_' . $date . '.csv';

            $varDir = $this->directoryList->getPath(DirectoryList::VAR_DIR);
            $exportPath = $varDir . DIRECTORY_SEPARATOR . 'magevision_exports' . DIRECTORY_SEPARATOR;
            $this->file->createDirectory($exportPath);

            $this->csv->appendData($exportPath . $filename, $exportData);
        }
    }

    /**
     * @return array
     */
    private function getCsvHeaders()
    {
        return [
            'First Name',
            'Last Name',
            'Email'
        ];
    }
}
