<?php
/**
 * MageVision Blog30
 *
 * @category     MageVision
 * @package      MageVision_Blog30
 * @author       MageVision Team
 * @copyright    Copyright (c) 2017 MageVision (https://www.magevision.com)
 * @license      http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
namespace MageVision\Blog30\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;
use Magento\Framework\Currency;

class CurrencySymbolChangePositionObserver implements ObserverInterface
{
    /**
     * currency_symbol_change_position
     *
     * @param Observer $observer
     * @return CurrencySymbolChangePositionObserver
     */
    public function execute(Observer $observer)
    {
        $currencyOptions = $observer->getEvent()->getCurrencyOptions();
        $currencyOptions->setData('position', Currency::RIGHT);
        return $this;
    }
}