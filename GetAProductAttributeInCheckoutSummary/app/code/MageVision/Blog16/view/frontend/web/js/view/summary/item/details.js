/**
 * MageVision Blog16
 *
 * @category     MageVision
 * @package      MageVision_Blog16
 * @author       MageVision Team
 * @copyright    Copyright (c) 2017 MageVision (https://www.magevision.com)
 * @license      http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
/*jshint browser:true jquery:true*/
/*global alert*/
define(
    [
        'uiComponent'
    ],
    function (Component) {
        "use strict";
        return Component.extend({
            defaults: {
                template: 'MageVision_Blog16/summary/item/details'
            },
            getValue: function(quoteItem) {
                return quoteItem.name;
            }
        });
    }
);
