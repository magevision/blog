<?php
/**
 * MageVision Blog51
 *
 * @category     MageVision
 * @package      MageVision_Blog51
 * @author       MageVision Team
 * @copyright    Copyright (c) 2019 MageVision (https://www.magevision.com)
 * @license      http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
namespace MageVision\Blog51\Controller\Post;

use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Customer\Model\Url;

class AddMessage extends Action
{
    /**
     * @var Url
     */
    protected $customerUrl;

    /**
     * @param Context $context
     * @param Url $customerUrl
     */
    public function __construct(
        Context $context,
        Url $customerUrl
    ) {
        $this->customerUrl = $customerUrl;
        parent::__construct($context);
    }

    /**
     * @return ResultInterface
     */
    public function execute()
    {
        $url = $this->customerUrl->getLoginUrl();
        $this->messageManager->addComplexSuccessMessage(
            'addRedirectAccountMessage',
            [
                'url' => $url
            ]
        );

        $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setPath('*/*/');
        return $resultRedirect;
    }
}
