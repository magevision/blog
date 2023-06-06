<?php
/**
 * MageVision Blog87
 *
 * @category     MageVision
 * @package      MageVision_Blog87
 * @author       MageVision Team
 * @copyright    Copyright (c) 2023 MageVision (https://www.magevision.com)
 * @license      http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

declare(strict_types=1);

namespace MageVision\Blog87\Setup\Patch\Data;

use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Setup\ModuleDataSetupInterface as ModuleDataSetupInterfaceAlias;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\InventoryApi\Api\Data\SourceInterface;
use Magento\InventoryApi\Api\Data\SourceInterfaceFactory;
use Magento\InventoryApi\Api\SourceRepositoryInterface;

class CreateInventorySource implements DataPatchInterface
{
    private ModuleDataSetupInterfaceAlias $moduleDataSetup;

    private SourceInterfaceFactory $sourceInterfaceFactory;

    private SourceRepositoryInterface $sourceRepositoryInterface;

    private DataObjectHelper $dataObjectHelper;

    /**
     * @param ModuleDataSetupInterfaceAlias $moduleDataSetup
     * @param SourceInterfaceFactory $sourceInterfaceFactory
     * @param SourceRepositoryInterface $sourceRepositoryInterface
     * @param DataObjectHelper $dataObjectHelper
     */
    public function __construct(
        ModuleDataSetupInterfaceAlias $moduleDataSetup,
        SourceInterfaceFactory $sourceInterfaceFactory,
        SourceRepositoryInterface $sourceRepositoryInterface,
        DataObjectHelper $dataObjectHelper
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->sourceInterfaceFactory = $sourceInterfaceFactory;
        $this->sourceRepositoryInterface = $sourceRepositoryInterface;
        $this->dataObjectHelper = $dataObjectHelper;
    }

    /**
     * @inheritDoc
     */
    public function apply()
    {
        $this->moduleDataSetup->startSetup();
        $sourceData = [
            SourceInterface::SOURCE_CODE => 'custom_source',
            SourceInterface::NAME => 'Custom Source',
            SourceInterface::ENABLED => 1,
            SourceInterface::DESCRIPTION => 'Custom Source',
            SourceInterface::LATITUDE => 0,
            SourceInterface::LONGITUDE => 0,
            SourceInterface::COUNTRY_ID => 'DE',
            SourceInterface::POSTCODE => '00000',
        ];

        $source = $this->sourceInterfaceFactory->create();
        $this->dataObjectHelper->populateWithArray($source, $sourceData, SourceInterface::class);
        $this->sourceRepositoryInterface->save($source);
        $this->moduleDataSetup->endSetup();
    }

    /**
     * @inheritDoc
     */
    public static function getDependencies()
    {
        return [];
    }

    /**
     * @inheritDoc
     */
    public function getAliases()
    {
        return [];
    }
}
