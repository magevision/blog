/**
 * MageVision Blog48
 *
 * @category     MageVision
 * @package      MageVision_Blog48
 * @author       MageVision Team
 * @copyright    Copyright (c) 2016 MageVision (https://www.magevision.com)
 * @license      http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

define([
    'jquery'
], function ($) {
    'use strict';

    return function (target) {

        $.validator.addMethod(
            'validate-greater-than-one',
            function (value) {
                return !(value <= 1);
            },
            $.mage.__('Please enter a number 2 or greater in this field.')
        );

        return target;
    };
});
