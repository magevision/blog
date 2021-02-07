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
        'Magento_OfflinePayments/js/view/payment/method-renderer/checkmo-method'
    ],
    function (Component) {
        'use strict';
        return Component.extend({
            defaults: {
                template: 'MageVision_Blog67/payment/checkmo'
            },
            /**
             * Get payment method Logo.
             */
            getLogo: function () {
                return window.checkoutConfig.payment.logo[this.item.method];
            },
            /**
             * Display Title next to Logo
             */
            displayTitleLogo: function () {
                return window.checkoutConfig.payment.display_logo_title[this.item.method];
            }
        });
    }
);
