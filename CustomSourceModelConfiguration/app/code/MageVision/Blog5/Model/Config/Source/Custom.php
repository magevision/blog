<?php
/**
 * MageVision Blog5
 *
 * @category     MageVision
 * @package      MageVision_Blog5
 * @author       MageVision Team
 * @copyright    Copyright (c) 2016 MageVision (https://www.magevision.com)
 * @license      http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
namespace MageVision\Blog5\Model\Config\Source;

class Custom implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * Retrieve Custom Option array
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => 1, 'label' => __('Option 1')],
            ['value' => 2, 'label' => __('Option 2')]
        ];
    }
}
