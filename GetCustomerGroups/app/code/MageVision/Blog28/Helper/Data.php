<?php
/**
 * MageVision Blog28
 *
 * @category     MageVision
 * @package      MageVision_Blog28
 * @author       MageVision Team
 * @copyright    Copyright (c) 2018 MageVision (https://www.magevision.com)
 * @license      http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
namespace MageVision\Blog28\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Customer\Model\ResourceModel\Group\CollectionFactory;

class Data extends AbstractHelper
{
    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @param Context $context
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(
        Context $context,
        CollectionFactory $collectionFactory
    ) {
        parent::__construct($context);
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * Get all customer groups to option array
     *
     * @return array
     */
    public function getCustomerGroupsArray()
    {
       return $this->collectionFactory->create()->toOptionArray();
    }
    /**
     * Get all customer groups collection
     *
     * @return \Magento\Customer\Model\ResourceModel\Group\Collection
     */
    public function getCustomerGroupsCollection()
    {
        return $this->collectionFactory->create();
    }
}





