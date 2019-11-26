<?php
/**
 * MageVision Blog52
 *
 * @category     MageVision
 * @package      MageVision_Blog52
 * @author       MageVision Team
 * @copyright    Copyright (c) 2019 MageVision (https://www.magevision.com)
 * @license      http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

declare(strict_types=1);

namespace MageVision\Blog52\Setup\Patch\Data;

use Magento\Catalog\Model\Category;
use Magento\Catalog\Setup\CategorySetupFactory;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;

class AddCategoryColorPickerAttribute implements DataPatchInterface
{
    /**
     * @var ModuleDataSetupInterface
     */
    protected $moduleDataSetup;

    /**
     * @var CategorySetupFactory
     */
    protected $categorySetupFactory;

    /**
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param CategorySetupFactory $categorySetupFactory
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        CategorySetupFactory $categorySetupFactory
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->categorySetupFactory = $categorySetupFactory;
    }

    /**
     * @inheritDoc
     */
    public function apply()
    {
        $this->moduleDataSetup->startSetup();

        $categorySetup = $this->categorySetupFactory->create(['setup' => $this->moduleDataSetup]);
        $categorySetup->addAttribute(Category::ENTITY, 'color_picker_attribute', [
            'type' => 'text',
            'label' => 'Color Picker Attribute',
            'input' => 'text',
            'required' => false,
            'global' => ScopedAttributeInterface::SCOPE_STORE,
            'is_user_defined' => true,
            'visible' => true,
            'group' => 'Content',
        ]);

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