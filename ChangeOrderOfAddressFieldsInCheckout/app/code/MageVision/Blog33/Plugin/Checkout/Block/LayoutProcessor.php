<?php
/**
 * MageVision Blog33
 *
 * @category     MageVision
 * @package      MageVision_Blog33
 * @author       MageVision Team
 * @copyright    Copyright (c) 2018 MageVision (https://www.magevision.com)
 * @license      http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
namespace MageVision\Blog33\Plugin\Checkout\Block;

class LayoutProcessor {

  /**
   * Position the telephone field after address fields
   *
   * @param \Magento\Checkout\Block\Checkout\LayoutProcessor $subject
   * @param array $jsLayout
   *
   * @return array
   */
   public function afterProcess(
      \Magento\Checkout\Block\Checkout\LayoutProcessor $subject,
      array  $jsLayout
    ) {

       //Shipping Address
       $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']
       ['children']['shippingAddress']['children']['shipping-address-fieldset']
       ['children']['telephone']['sortOrder'] = 75;

      //Billing Address on payment method
       if (isset($jsLayout['components']['checkout']['children']['steps']['children']['billing-step']['children']
           ['payment']['children']['payments-list']['children']
       )) {
           $paymentList = $jsLayout['components']['checkout']['children']['steps']['children']['billing-step']['children']
           ['payment']['children']['payments-list']['children'];

           foreach ($paymentList as $key => $payment) {

               /* telephone */
               $jsLayout['components']['checkout']['children']['steps']['children']['billing-step']['children']
                   ['payment']['children']['payments-list']['children'][$key]['children']['form-fields']['children']
                   ['telephone']['sortOrder'] = 75;
               }
       }

       //Billing Address on payment page
       if (isset($jsLayout['components']['checkout']['children']['steps']['children']['billing-step']['children']
           ['payment']['children']['afterMethods']['children']
       )) {

           /* telephone */
           $jsLayout['components']['checkout']['children']['steps']['children']['billing-step']['children']
           ['payment']['children']['afterMethods']['children']['billing-address-form']['children']['form-fields']
           ['children']['telephone']['sortOrder'] = 75;

       }
    return $jsLayout;
  }
}