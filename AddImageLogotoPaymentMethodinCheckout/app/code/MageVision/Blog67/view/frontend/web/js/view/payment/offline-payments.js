/**
 * MageVision Blog67
 *
 * @category    MageVision
 * @package     MageVision_Blog67
 * @author      MageVision Team
 * @copyright   Copyright (c) 2020 MageVision (https://www.magevision.com)
 */
define(
    [
        'uiComponent',
        'Magento_Checkout/js/model/payment/renderer-list'
    ],
    function (
        Component,
        rendererList
    ) {
        'use strict';
        rendererList.push(
            {
                type: 'checkmo',
                component: 'MageVision_Blog67/js/view/payment/method-renderer/checkmo-method'
            },
            {
                type: 'banktransfer',
                component: 'Magento_OfflinePayments/js/view/payment/method-renderer/banktransfer-method'
            },
            {
                type: 'cashondelivery',
                component: 'Magento_OfflinePayments/js/view/payment/method-renderer/cashondelivery-method'
            },
            {
                type: 'purchaseorder',
                component: 'Magento_OfflinePayments/js/view/payment/method-renderer/purchaseorder-method'
            }
        );
        /** Add view logic here if needed */
        return Component.extend({});
    }
);
