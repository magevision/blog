<?php
/**
 * MageVision Blog78
 *
 * @category     MageVision
 * @package      MageVision_Blog78
 * @author       MageVision Team
 * @copyright    Copyright (c) 2022 MageVision (https://www.magevision.com)
 * @license      http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

namespace MageVision\Blog78\Model;

use Magento\Payment\Model\Method\AbstractMethod;

class AdminOnly extends AbstractMethod
{
    const PAYMENT_METHOD_ADMIN_ONLY_CODE = 'admin_only';

    /**
     * Payment method code
     *
     * @var string
     */
    protected $_code = self::PAYMENT_METHOD_ADMIN_ONLY_CODE;
}
