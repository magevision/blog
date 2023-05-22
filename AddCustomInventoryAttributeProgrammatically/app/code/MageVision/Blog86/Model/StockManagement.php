<?php
/**
 * MageVision Blog86
 *
 * @category     MageVision
 * @package      MageVision_Blog86
 * @author       MageVision Team
 * @copyright    Copyright (c) 2023 MageVision (https://www.magevision.com)
 * @license      http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
namespace MageVision\Blog86\Model;

use Magento\CatalogInventory\Api\StockRegistryInterface;
use Magento\Framework\Exception\NoSuchEntityException;

class StockManagement
{
    private StockRegistryInterface $stockRegistry;

    /**
     * @param StockRegistryInterface $stockRegistry
     */
    public function __construct(
        StockRegistryInterface $stockRegistry
    ) {
        $this->stockRegistry = $stockRegistry;
    }

    /**
     * @param string $sku
     * @param bool $comingSoon
     * @return void
     * @throws NoSuchEntityException
     */
    public function update(string $sku, bool $comingSoon): void
    {
        $stockItem = $this->stockRegistry->getStockItemBySku($sku);
        $stockItem->setData('coming_soon', $comingSoon);
        $this->stockRegistry->updateStockItemBySku($sku, $stockItem);
    }
}
