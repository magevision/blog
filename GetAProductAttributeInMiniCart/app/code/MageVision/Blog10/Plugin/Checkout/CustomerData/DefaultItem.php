<?php
/**
 * MageVision Blog10
 *
 * @category     MageVision
 * @package      MageVision_Blog10
 * @author       MageVision Team
 * @copyright    Copyright (c) 2016 MageVision (https://www.magevision.com)
 * @license      http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
namespace MageVision\Blog10\Plugin\Checkout\CustomerData;

class DefaultItem
{
    public function aroundGetItemData(
        \Magento\Checkout\CustomerData\AbstractItem $subject,
        \Closure $proceed,
        \Magento\Quote\Model\Quote\Item $item
    ) {
        $data = $proceed($item);
        $result['manufacturer'] = $item->getProduct()->getAttributeText('manufacturer');

        return \array_merge(
            $result,
            $data
        );
    }
}
