<?php
/**
 * MageVision Blog27
 *
 * @category     MageVision
 * @package      MageVision_Blog27
 * @author       MageVision Team
 * @copyright    Copyright (c) 2018 MageVision (https://www.magevision.com)
 * @license      http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
namespace MageVision\Blog27\Plugin\Sales\Block\Adminhtml\Order;

use Magento\Sales\Block\Adminhtml\Order\View as OrderView;

class View
{
    public function beforeSetLayout(OrderView $subject)
    {
        $subject->addButton(
            'order_custom_button',
            [
                'label' => __('Custom Button'),
                'class' => __('custom-button'),
                'id' => 'order-view-custom-button',
                'onclick' => 'setLocation(\'' . $subject->getUrl('module/controller/action') . '\')'
            ]
        );
    }
}
