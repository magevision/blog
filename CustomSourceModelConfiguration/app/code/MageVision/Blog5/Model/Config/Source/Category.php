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

use Magento\Catalog\Api\CategoryManagementInterface;

class Category implements \Magento\Framework\Option\ArrayInterface
{

    /**
     * @var array
     */
    protected $options = null;

    /**
     * @var string
     */
    protected $separator;
    
    /**
     * @var CategoryManagementInterface
     */
    protected $categoryManagement;

    /**
     * @param CategoryManagementInterface $categoryManagement
     */
    public function __construct(
        CategoryManagementInterface $categoryManagement
    ) {
        $this->categoryManagement = $categoryManagement;
    }

    /**
     * Return array of categories
     *
     * @return array
     */
    public function toOptionArray()
    {
        if ($this->options === null) {
            $this->options = [];
            $categories = $this->categoryManagement->getTree();

            foreach ($categories->getChildrenData() as $category) {
                //Uncomment the following line to display only the active categories
                //if(!$category->getIsActive()) continue;
                $this->separator = '';
                $this->options[] = [
                    'value' => $category->getId(),
                    'label' => $category->getName(),
                ];
                if ($category->getChildrenData()) {
                    $this->addSubcategories($category->getChildrenData());
                }
            }
        }

        return $this->options;
    }

    /**
     * @var \Magento\Catalog\Api\Data\CategoryTreeInterface[]
     *
     * @return $this
     */
    public function addSubcategories($subcategories)
    {
        $this->separator .= '-';
        foreach ($subcategories as $subcategory) {
            $this->options[] = [
                'value' => $subcategory->getId(),
                'label' => $this->separator.' '.$subcategory->getName(),
            ];
            if ($subcategory->getChildrenData()) {
                $this->addSubcategories($subcategory->getChildrenData());
            }
        }
        $this->separator = substr($this->separator, 0, -1);
        
        return $this;
    }
}
