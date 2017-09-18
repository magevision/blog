<?php
/**
 * MageVision Blog20
 *
 * @category     MageVision
 * @package      MageVision_Blog20
 * @author       MageVision Team
 * @copyright    Copyright (c) 2017 MageVision (https://www.magevision.com)
 * @license      http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
namespace MageVision\Blog20\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\OfflinePayments\Model\Banktransfer;
use Magento\Framework\Event\Observer;
use Magento\Customer\Model\Session;

class PaymentMethodIsActiveObserver implements ObserverInterface
{
    /**
     * @var Session
     */
    protected $customerSession;

    /**
     * @param \Magento\Customer\Model\Session $customerSession
     */
    public function __construct(
        Session $customerSession
    ) {
        $this->customerSession = $customerSession;
    }

    /**
     * payment_method_is_active event handler
     *
     * @param Observer $observer
     */
    public function execute(Observer $observer)
    {
        //our example will disable the Banktransfer payment method
        //you can easily replace the Banktransfer code with yours payment method code
        if ($observer->getEvent()->getMethodInstance()->getCode() == Banktransfer::PAYMENT_METHOD_BANKTRANSFER_CODE) {
            $checkResult = $observer->getEvent()->getResult();
            if(!$this->customerSession->isLoggedIn()) {
                $checkResult->setData('is_available', false);
            }
        }
    }
}