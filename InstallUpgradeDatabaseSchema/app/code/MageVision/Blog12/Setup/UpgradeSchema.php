<?php
/**
 * MageVision Blog12
 *
 * @category     MageVision
 * @package      MageVision_Blog12
 * @author       MageVision Team
 * @copyright    Copyright (c) 2016 MageVision (https://www.magevision.com)
 * @license      http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
namespace MageVision\Blog12\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class UpgradeSchema implements UpgradeSchemaInterface
{
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();

        $version = $context->getVersion();
        $connection = $installer->getConnection();

        if (version_compare($version, '2.0.1') < 0) {

            $connection->addColumn(
                $installer->getTable('magevision_blog12'),
                'image',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => 255,
                    'nullable' => true,
                    'comment' => 'Post Image',
                ]
            );
        }

        $setup->endSetup();
    }
}
