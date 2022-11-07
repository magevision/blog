<?php
/**
 * MageVision Blog79
 *
 * @category     MageVision
 * @package      MageVision_Blog79
 * @author       MageVision Team
 * @copyright    Copyright (c) 2022 MageVision (https://www.magevision.com)
 * @license      http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

declare(strict_types=1);

namespace MageVision\Blog79\Setup\Patch\Data;

use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Config\Model\ResourceModel\Config as ResourceConfig;

class SetStoreConfiguration implements DataPatchInterface
{
    private ModuleDataSetupInterface $moduleDataSetup;

    private ResourceConfig $resourceConfig;

    /**
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param ResourceConfig $resourceConfig
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        ResourceConfig $resourceConfig
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->resourceConfig = $resourceConfig;
    }

    /**
     * {@inheritdoc}
     */
    public function apply()
    {
        $this->moduleDataSetup->startSetup();
        $this->resourceConfig->saveConfig('general/locale/timezone', 'Europe/Berlin');
        $this->moduleDataSetup->endSetup();
    }

    /**
     * {@inheritdoc}
     */
    public static function getDependencies()
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function getAliases()
    {
        return [];
    }
}
