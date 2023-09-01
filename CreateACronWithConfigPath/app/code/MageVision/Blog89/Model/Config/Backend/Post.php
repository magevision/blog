<?php
/**
 * MageVision Blog89
 *
 * @category     MageVision
 * @package      MageVision_Blog89
 * @author       MageVision Team
 * @copyright    Copyright (c) 2023 MageVision (https://www.magevision.com)
 * @license      http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

declare(strict_types=1);

namespace MageVision\Blog89\Model\Config\Backend;

use Magento\Cron\Model\Config\Source\Frequency;
use Magento\Framework\App\Cache\TypeListInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Config\Value;
use Magento\Framework\App\Config\ValueFactory;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Model\Context;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Registry;

class Post extends Value
{
    public const CRON_STRING_PATH = 'crontab/default/jobs/magevision_blog89_cron/schedule/cron_expr';

    protected ValueFactory $configValueFactory;

    /**
     * @param Context $context
     * @param Registry $registry
     * @param ScopeConfigInterface $config
     * @param TypeListInterface $cacheTypeList
     * @param ValueFactory $configValueFactory
     * @param AbstractResource|null $resource
     * @param AbstractDb|null $resourceCollection
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        ScopeConfigInterface $config,
        TypeListInterface $cacheTypeList,
        ValueFactory $configValueFactory,
        AbstractResource $resource = null,
        AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        $this->configValueFactory = $configValueFactory;
        parent::__construct($context, $registry, $config, $cacheTypeList, $resource, $resourceCollection, $data);
    }

    /**
     * After save handler
     *
     * @return $this
     * @throws LocalizedException
     */
    public function afterSave()
    {
        $time = $this->getData('groups/post/fields/time/value');
        if (empty($time)) {
            $time = explode(
                ',',
                $this->_config->getValue(
                    'blog89/post/time',
                    $this->getScope(),
                    $this->getScopeId()
                ) ?: '0,0,0'
            );
            $frequency = $this->_config->getValue(
                'blog89/post/frequency',
                $this->getScope(),
                $this->getScopeId()
            );
        } else {
            $frequency = $this->getData('groups/post/fields/frequency/value');
        }
        $frequencyWeekly = Frequency::CRON_WEEKLY;
        $frequencyMonthly = Frequency::CRON_MONTHLY;

        $cronExprArray = [
            (int)$time[1],                                    # Minute
            (int)$time[0],                                    # Hour
            $frequency == $frequencyMonthly ? '1' : '*',      # Day of the Month
            '*',                                              # Month of the Year
            $frequency == $frequencyWeekly ? '1' : '*',       # Day of the Week
        ];

        $cronExprString = join(' ', $cronExprArray);

        try {
            $configValue = $this->configValueFactory->create();
            $configValue->load(self::CRON_STRING_PATH, 'path');
            $configValue->setValue($cronExprString)->setPath(self::CRON_STRING_PATH)->save();
        } catch (\Exception $e) {
            throw new LocalizedException(__('We can\'t save the Cron expression.'));
        }
        return parent::afterSave();
    }
}
