<?php
/**
 * MageVision Blog37
 *
 * @category     MageVision
 * @package      MageVision_Blog37
 * @author       MageVision Team
 * @copyright    Copyright (c) 2018 MageVision (https://www.magevision.com)
 * @license      http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
namespace MageVision\Blog37\Plugin\Catalog\Helper\Product;

use Magento\Catalog\Model\Product;
use Magento\Framework\View\Result\Page as ResultPage;

class View
{
    public function beforeInitProductLayout(
        \Magento\Catalog\Helper\Product\View $subject,
        ResultPage $resultPage,
        Product $product,
        $params = null
    ) {
        $resultPage->addPageLayoutHandles(
            ['attribute_set_id' => $product->getAttributeSetId()]
        );

        return [$resultPage, $product, $params];
    }
}