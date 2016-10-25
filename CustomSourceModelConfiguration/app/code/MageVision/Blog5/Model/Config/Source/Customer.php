<?php
/**
 * MageVision Blog5
 *
 * @category     MageVision
 * @package      MageVision_Blog5
 * @author       MageVision Team
 * @copyright    Copyright (c) 2016 MageVision (https://www.magevision.com)
 * @license      http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
namespace MageVision\Blog5\Model\Config\Source;

use Magento\Customer\Model\ResourceModel\Customer\CollectionFactory;

class Customer implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * @var array
     */
    protected $options = null;

    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(
        CollectionFactory $collectionFactory
    ) {
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * Return array of customers
     *
     * @return array
     */
    public function toOptionArray()
    {
        if ($this->options === null) {
            $customers = $this->collectionFactory->create();
            
            foreach ($customers as $customer) {
                $this->options[] = [
                    'value' => $customer->getId(),
                    'label' => $customer->getName(),
                ];
            }
        }
        
        return $this->options;
    }
}
