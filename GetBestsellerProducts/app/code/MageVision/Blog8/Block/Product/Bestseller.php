<?php
/**
 * MageVision Blog8
 *
 * @category     MageVision
 * @package      MageVision_Blog8
 * @author       MageVision Team
 * @copyright    Copyright (c) 2016 MageVision (https://www.magevision.com)
 * @license      http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
namespace MageVision\Blog8\Block\Product;

class Bestseller extends \Magento\Catalog\Block\Product\AbstractProduct
{
    /**
     * @var \Magento\Sales\Model\ResourceModel\Report\Bestsellers\CollectionFactory
     */
    protected $bestsellersCollectionFactory;

    /**
     * Product collection factory
     *
     * @var \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory
     */
    protected $productCollectionFactory;

    /**
     * Catalog product visibility
     *
     * @var \Magento\Catalog\Model\Product\Visibility
     */
    protected $catalogProductVisibility;

    /**
     * @var \Magento\Catalog\Model\Product\Attribute\Source\Status
     */
    protected $productStatus;

    /**
     * @param \Magento\Catalog\Block\Product\Context $context
     * @param \Magento\Sales\Model\ResourceModel\Report\Bestsellers\CollectionFactory $bestsellersCollectionFactory
     * @param \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory
     * @param \Magento\Catalog\Model\Product\Visibility $catalogProductVisibility
     * @param \Magento\Catalog\Model\Product\Attribute\Source\Status $productStatus
     * @param array $data
     */
    public function __construct(
        \Magento\Catalog\Block\Product\Context $context,
        \Magento\Sales\Model\ResourceModel\Report\Bestsellers\CollectionFactory $bestsellersCollectionFactory,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,
        \Magento\Catalog\Model\Product\Visibility $catalogProductVisibility,
        \Magento\Catalog\Model\Product\Attribute\Source\Status $productStatus,
        array $data = []
    ) {
        $this->bestsellersCollectionFactory = $bestsellersCollectionFactory;
        $this->productCollectionFactory = $productCollectionFactory;
        $this->catalogProductVisibility = $catalogProductVisibility;
        $this->productStatus = $productStatus;
        parent::__construct($context, $data);
    }

    /**
     * Getting the best seller product ids
     *
     * @param array $ids
     */
    protected function getBestsellerProductIds()
    {
        $storeId = $this->_storeManager->getStore()->getId();
        $items = $this->bestsellersCollectionFactory->create()->setModel(
            'Magento\Catalog\Model\Product'
        )->addStoreFilter(
            $storeId
        );
        $ids = [];
        foreach ($items as $item) {
            $ids[] = $item->getProductId();
        }
        
        return $ids;
    }

    /**
     * @return \Magento\Catalog\Model\ResourceModel\Product\Collection
     */
    public function getItems()
    {
        $collection = $this->productCollectionFactory->create();
        $collection->addIdFilter($this->getBestsellerProductIds());
        $collection->addAttributeToFilter('status',
            ['in' => $this->productStatus->getVisibleStatusIds()]);
        $collection->setVisibility($this->catalogProductVisibility->getVisibleInCatalogIds());

        $collection = $this->_addProductAttributesAndPrices(
                $collection
            )->addStoreFilter();

        return $collection;
    }
}