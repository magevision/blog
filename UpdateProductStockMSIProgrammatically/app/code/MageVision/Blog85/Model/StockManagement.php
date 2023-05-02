<?php
/**
 * MageVision Blog85
 *
 * @category     MageVision
 * @package      MageVision_Blog85
 * @author       MageVision Team
 * @copyright    Copyright (c) 2023 MageVision (https://www.magevision.com)
 * @license      http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

namespace MageVision\Blog85\Model;

use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\InputException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Validation\ValidationException;
use Magento\InventoryApi\Api\Data\SourceItemInterface;
use Magento\InventoryApi\Api\GetSourceItemsBySkuInterface;
use Magento\InventoryApi\Api\SourceItemsSaveInterface;
use Magento\InventoryCatalogApi\Api\DefaultSourceProviderInterface;
use Magento\InventorySourceDeductionApi\Model\GetSourceItemBySourceCodeAndSku;

class StockManagement
{
    private SourceItemsSaveInterface $sourceItemsSaveInterface;

    private GetSourceItemsBySkuInterface $getSourceItemsBySkuInterface;

    private DefaultSourceProviderInterface $defaultSourceProvider;

    private GetSourceItemBySourceCodeAndSku $getSourceItemBySourceCodeAndSku;

    /**
     * @param SourceItemsSaveInterface $sourceItemsSaveInterface
     * @param GetSourceItemsBySkuInterface $getSourceItemsBySkuInterface
     * @param DefaultSourceProviderInterface $defaultSourceProvider
     * @param GetSourceItemBySourceCodeAndSku $getSourceItemBySourceCodeAndSku
     */
    public function __construct(
        SourceItemsSaveInterface $sourceItemsSaveInterface,
        GetSourceItemsBySkuInterface $getSourceItemsBySkuInterface,
        DefaultSourceProviderInterface $defaultSourceProvider,
        GetSourceItemBySourceCodeAndSku $getSourceItemBySourceCodeAndSku
    ) {
        $this->sourceItemsSaveInterface = $sourceItemsSaveInterface;
        $this->getSourceItemsBySkuInterface = $getSourceItemsBySkuInterface;
        $this->defaultSourceProvider = $defaultSourceProvider;
        $this->getSourceItemBySourceCodeAndSku = $getSourceItemBySourceCodeAndSku;
    }

    /**
     * @param string $sku
     * @param float $qty
     * @param string|null $source
     * @return void
     * @throws CouldNotSaveException
     * @throws InputException
     * @throws ValidationException
     * @throws NoSuchEntityException
     */
    public function update(string $sku, float $qty, string $source = null): void
    {
        //In case we want to update a specific or the default source
        if ($source) {
            $sourceItem = $this->getSourceItemBySourceCodeAndSku->execute($source, $sku);
        } else {
            $sourceItem = $this->getSourceItemBySourceCodeAndSku->execute($this->defaultSourceProvider->getCode(), $sku);
        }

        $sourceItem->setQuantity($qty);
        $sourceItem->setStatus($qty > 0 ? SourceItemInterface::STATUS_IN_STOCK : SourceItemInterface::STATUS_OUT_OF_STOCK);
        $this->sourceItemsSaveInterface->execute([$sourceItem]);

        //In case we want to update all sources at once
        $sourceItems = $this->getSourceItemsBySkuInterface->execute($sku);
        foreach ($sourceItems as $sourceItem) {
            $sourceItem->setQuantity($qty);
            $sourceItem->setStatus($qty > 0 ? SourceItemInterface::STATUS_IN_STOCK : SourceItemInterface::STATUS_OUT_OF_STOCK);
            $this->sourceItemsSaveInterface->execute([$sourceItem]);
        }
    }
}
