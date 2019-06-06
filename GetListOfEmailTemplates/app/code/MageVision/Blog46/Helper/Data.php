<?php
/**
 * MageVision Blog46
 *
 * @category     MageVision
 * @package      MageVision_Blog46
 * @author       MageVision Team
 * @copyright    Copyright (c) 2019 MageVision (https://www.magevision.com)
 * @license      http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
namespace MageVision\Blog46\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Email\Model\ResourceModel\Template\CollectionFactory;
use Magento\Email\Model\Template\Config;

class Data extends AbstractHelper
{
    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;


    /**
     * @var Config
     */
    protected $emailConfig;

    /**
     * @param Context $context
     * @param CollectionFactory $collectionFactory
     * @param Config $emailConfig
     */
    public function __construct(
        Context $context,
        CollectionFactory $collectionFactory,
        Config $emailConfig
    ) {
        parent::__construct($context);
        $this->collectionFactory = $collectionFactory;
        $this->emailConfig = $emailConfig;
    }

    /**
     * Returns collection of all custom templates created in backend
     *
     * @return mixed
     */
    public function getCustomTemplates()
    {
        return $this->collectionFactory->create();
    }

    /**
     * Return list of all email templates, both default module and theme-specific templates
     *
     * @return array[]
     */
    public function getConfigTemplates()
    {
        return $this->emailConfig->getAvailableTemplates();
    }
}





