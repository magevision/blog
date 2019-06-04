<?php
/**
 * MageVision Blog45
 *
 * @category     MageVision
 * @package      MageVision_Blog45
 * @author       MageVision Team
 * @copyright    Copyright (c) 2019 MageVision (https://www.magevision.com)
 * @license      http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
namespace MageVision\Blog45\Plugin\Checkout\CustomerData;

use Magento\Checkout\Model\Session as CheckoutSession;
use Magento\Checkout\Helper\Data as CheckoutHelper;
use Magento\Quote\Model\Quote;

class Cart
{
    /**
     * @var CheckoutSession
     */
    protected $checkoutSession;
    
    /**
     * @var CheckoutHelper
     */
    protected $checkoutHelper;

    /**
     * @var Quote|null
     */
    protected $quote = null;

    /**
     * @param CheckoutSession $checkoutSession
     * @param CheckoutHelper $checkoutHelper
     */
    public function __construct(
        CheckoutSession $checkoutSession,
        CheckoutHelper $checkoutHelper
    ) {
        $this->checkoutSession = $checkoutSession;
        $this->checkoutHelper = $checkoutHelper;
    }

    /**
     * Add grand total to result
     *
     * @param \Magento\Checkout\CustomerData\Cart $subject
     * @param array $result
     * @return array
     */
    public function afterGetSectionData(
        \Magento\Checkout\CustomerData\Cart $subject,
        $result
    ) {

        $totals = $this->getQuote()->getTotals();
        $result['grand_total'] = isset($totals['grand_total'])
            ? $this->checkoutHelper->formatPrice($totals['grand_total']->getValue())
            : 0;
        return $result;
    }

    /**
     * Get active quote
     *
     * @return Quote
     */
    protected function getQuote()
    {
        if (null === $this->quote) {
            $this->quote = $this->checkoutSession->getQuote();
        }
        return $this->quote;
    }
}
