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

namespace MageVision\Blog89\Cron;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class Post
{
    public const XML_PATH_ENABLE = 'blog89/post/enabled';

    protected ScopeConfigInterface $scopeConfig;

    /**
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig
    ) {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * Execute cron
     *
     * @return void
     */
    public function execute()
    {
        // check if enabled
        if (!$this->scopeConfig->isSetFlag(
            self::XML_PATH_ENABLE,
            ScopeInterface::SCOPE_STORE
        )
        ) {
            return;
        }

        //Add your code

    }
}
