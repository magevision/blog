<?php
/**
 * MageVision Blog40
 *
 * @category     MageVision
 * @package      MageVision_Blog40
 * @author       MageVision Team
 * @copyright    Copyright (c) 2019 MageVision (https://www.magevision.com)
 * @license      http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
namespace MageVision\Blog40\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Catalog\Api\Data\ProductCustomOptionInterface;
use Magento\Catalog\Model\Product\OptionFactory;

class CatalogProductSaveBeforeObserver implements ObserverInterface
{
    /**
     * @var OptionFactory
     */
    protected $productOptionFactory;

    /**
     * Catalog Product After Save constructor.
     * @param OptionFactory $productOptionFactory
     */
    public function __construct(
        OptionFactory $productOptionFactory
    ) {
        $this->productOptionFactory = $productOptionFactory;
    }

    /**
     * Catalog Product Before Save
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $product = $observer->getEvent()->getProduct();

        $exist = false;
        //check if the custom option exists
        foreach ($product->getOptions() as $option) {
            if ($option->getGroupByType() == ProductCustomOptionInterface::OPTION_TYPE_FIELD
                && $option->getTitle() == 'Custom Option') {
                $exist = true;
            }
        }

        if (!$exist) {
            try {
                $optionArray = [
                    'title' => 'Custom Option',
                    'type' => 'field',
                    'is_require' => false,
                    'sort_order' => 1,
                    'price' => 0,
                    'price_type' => 'fixed',
                    'sku' => '',
                    'max_characters' => 0
                ];
                $option = $this->productOptionFactory->create();
                $option->setProductId($product->getId())
                    ->setStoreId($product->getStoreId())
                    ->addData($optionArray);
                $product->addOption($option);
            } catch (\Exception $e) {
                //throw new CouldNotSaveException(__('Something went wrong while saving option.'));
            }
        }
    }
}
