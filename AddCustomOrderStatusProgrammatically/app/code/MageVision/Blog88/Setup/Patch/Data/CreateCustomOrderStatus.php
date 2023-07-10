<?php
/**
 * MageVision Blog88
 *
 * @category     MageVision
 * @package      MageVision_Blog88
 * @author       MageVision Team
 * @copyright    Copyright (c) 2023 MageVision (https://www.magevision.com)
 * @license      http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

declare(strict_types=1);

namespace MageVision\Blog88\Setup\Patch\Data;

use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Sales\Model\Order;

class CreateCustomOrderStatus implements DataPatchInterface
{
    private const STATUS_CODE = 'custom_status';
    private const STATUS_LABEL = 'Custom';

    private ModuleDataSetupInterface $moduleDataSetup;

    /**
     * @param ModuleDataSetupInterface $moduleDataSetup
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
    }

    /**
     * @inheritDoc
     */
    public function apply()
    {
        $this->moduleDataSetup->startSetup();

        $this->moduleDataSetup->getConnection()->insert(
            $this->moduleDataSetup->getTable('sales_order_status'),
            [
                'status' => self::STATUS_CODE,
                'label' => self::STATUS_LABEL
            ]
        );

        $this->moduleDataSetup->getConnection()->insert(
            $this->moduleDataSetup->getTable('sales_order_status_state'),
            [
                'status' => self::STATUS_CODE,
                'state' => Order::STATE_PROCESSING,
                'is_default' => 0,
                'visible_on_front' => 1
            ]
        );

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
