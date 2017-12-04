<?php
/**
 * MageVision Blog24
 *
 * @category     MageVision
 * @package      MageVision_Blog24
 * @author       MageVision Team
 * @copyright    Copyright (c) 2017 MageVision (http://www.magevision.com)
 * @license      LICENSE_MV.txt or http://www.magevision.com/license-agreement/
 */
namespace MageVision\Blog24\Controller\Post;

use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Customer\Model\Session;

class Index extends Action
{
    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var Session
     */
    protected $customerSession;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param Session $customerSession
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        Session $customerSession
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->customerSession = $customerSession;
        parent::__construct($context);
    }

    /**
     * Allow only customers - redirect to login page
     *
     * @param RequestInterface $request
     * @return \Magento\Framework\App\ResponseInterface
     * @throws \Magento\Framework\Exception\NotFoundException
     */
    public function dispatch(RequestInterface $request)
    {
        if (!$this->customerSession->authenticate()) {
            $this->_actionFlag->set('', self::FLAG_NO_DISPATCH, true);
            $this->customerSession->setBeforeAuthUrl($this->_url->getUrl(
                'blog24/post/index'
            ));
        }

        return parent::dispatch($request);
    }

    /**
     * Default page
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        return $this->resultPageFactory->create();
    }
}
