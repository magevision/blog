<?php
/**
 * MageVision Blog77
 *
 * @category     MageVision
 * @package      MageVision_Blog77
 * @author       MageVision Team
 * @copyright    Copyright (c) 2022 MageVision (https://www.magevision.com)
 * @license      http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

namespace MageVision\Blog77\Plugin\OfflinePayments\Model;

use Magento\Backend\Model\Auth\Session;
use Magento\OfflinePayments\Model\Checkmo;
use Magento\Quote\Api\Data\CartInterface;

class CheckmoPlugin
{
    private Session $backendSession;

    /**
     * @param Session $backendSession
     */
    public function __construct(
        Session $backendSession
    ) {
        $this->backendSession = $backendSession;
    }

    /**
     * @param Checkmo $subject
     * @param $result
     * @param CartInterface|null $quote
     * @return false|mixed
     */
    public function afterIsAvailable(
        Checkmo $subject,
        $result,
        CartInterface $quote = null
    ) {
        if ($this->backendSession->isLoggedIn()) {
            return $result;
        }

        return false;
    }
}
