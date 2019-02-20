<?php
/**
 * MageVision Blog38
 *
 * @category     MageVision
 * @package      MageVision_Blog38
 * @author       MageVision Team
 * @copyright    Copyright (c) 2019 MageVision (https://www.magevision.com)
 * @license      http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
namespace MageVision\Blog38\Plugin\Catalog\Model\Category\Attribute\Source;

class Mode
{
    /**
     * @param \Magento\Catalog\Model\Category\Attribute\Source\Mode $subject
     * @param $result
     * @return array
     */
    public function afterGetAllOptions(
        \Magento\Catalog\Model\Category\Attribute\Source\Mode $subject,
        $result
    ) {
        $result[] = ['value' => 'CUSTOM_MODE', 'label' => 'Custom Mode'];
        return $result;
    }
}