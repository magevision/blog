<?php
/**
 * MageVision Blog90
 *
 * @category     MageVision
 * @package      MageVision_Blog90
 * @author       MageVision Team
 * @copyright    Copyright (c) 2023 MageVision (https://www.magevision.com)
 * @license      http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

declare(strict_types=1);

namespace MageVision\Blog90\Setup\Patch\Data;

use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\Patch\PatchRevertableInterface;
use Magento\Tax\Api\Data\TaxClassKeyInterface;
use Magento\Tax\Api\Data\TaxClassKeyInterfaceFactory;
use Magento\Tax\Api\TaxClassManagementInterface;
use Magento\Tax\Model\TaxClass\Management;

class InstallCustomerCustomGroup implements DataPatchInterface, PatchRevertableInterface
{
    private const RETAILER_TAX_CLASS_NAME = 'Retail Customer';

    public const CUSTOMER_GROUP_MAGEVISION = 'MageVision';

    private ModuleDataSetupInterface $moduleDataSetup;

    private Management $management;

    private TaxClassKeyInterfaceFactory $taxClassKeyFactory;

    /**
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param Management $management
     * @param TaxClassKeyInterfaceFactory $taxClassKeyFactory
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        Management $management,
        TaxClassKeyInterfaceFactory $taxClassKeyFactory
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->management = $management;
        $this->taxClassKeyFactory = $taxClassKeyFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function apply()
    {
        $this->moduleDataSetup->startSetup();

        $taxClassKey = $this->taxClassKeyFactory->create();
        $taxClassKey->setType(TaxClassKeyInterface::TYPE_NAME)
            ->setValue(self::RETAILER_TAX_CLASS_NAME);

        $taxClassId = $this->management->getTaxClassId($taxClassKey, TaxClassManagementInterface::TYPE_CUSTOMER);
        $this->moduleDataSetup->getConnection()->insertForce(
            $this->moduleDataSetup->getTable('customer_group'),
            ['customer_group_code' => self::CUSTOMER_GROUP_MAGEVISION, 'tax_class_id' => $taxClassId]
        );

        $this->moduleDataSetup->endSetup();
    }

    /**
     * {@inheritdoc}
     */
    public function revert(): void
    {
        $this->moduleDataSetup->getConnection()->startSetup();

        $this->moduleDataSetup->getConnection()->delete(
            $this->moduleDataSetup->getTable('customer_group'),
            ['customer_group_code = ?' => self::CUSTOMER_GROUP_MAGEVISION]
        );

        $this->moduleDataSetup->getConnection()->endSetup();
    }

    /**
     * @inheritdoc
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
