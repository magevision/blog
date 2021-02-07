<?php
/**
 * MageVision Blog67
 *
 * @category    MageVision
 * @package     MageVision_Blog67
 *
 * @author      MageVision Team
 * @copyright   Copyright (c) 2020 MageVision (https://www.magevision.com)
 */
namespace MageVision\Blog67\Model;

use Magento\Framework\Api\AttributeValueFactory;
use Magento\Framework\Api\ExtensionAttributesFactory;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Model\Context;
use Magento\Framework\Registry;
use Magento\Framework\UrlInterface;
use Magento\Payment\Helper\Data;
use Magento\Payment\Model\Method\Logger;
use Magento\Store\Model\StoreManagerInterface;

class Checkmo extends \Magento\OfflinePayments\Model\Checkmo
{
    const LOGO_DIR = 'payments/logo/';

    /**
     * Store manager
     *
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @param Context $context
     * @param Registry $registry
     * @param ExtensionAttributesFactory $extensionFactory
     * @param AttributeValueFactory $customAttributeFactory
     * @param Data $paymentData
     * @param ScopeConfigInterface $scopeConfig
     * @param Logger $logger
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        Context $context,
        Registry $registry,
        ExtensionAttributesFactory $extensionFactory,
        AttributeValueFactory $customAttributeFactory,
        Data $paymentData,
        ScopeConfigInterface $scopeConfig,
        Logger $logger,
        StoreManagerInterface $storeManager
    ) {
        parent::__construct(
            $context,
            $registry,
            $extensionFactory,
            $customAttributeFactory,
            $paymentData,
            $scopeConfig,
            $logger
        );
        $this->storeManager = $storeManager;
    }

    /**
     * Get logo image from config
     *
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     *
     * @return string
     */
    public function getLogo()
    {
        $logoUrl = false;

        if ($file = trim($this->getConfigData('logo'))) {
            $fileUrl = self::LOGO_DIR . $file;
            $mediaUrl = $this->storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA);
            $logoUrl = $mediaUrl . $fileUrl;
        }

        return $logoUrl;
    }

    /**
     * Display Title next to Logo
     *
     * @return int
     */
    public function displayTitleLogo()
    {
        return (int) $this->getConfigData('display_logo_title');
    }
}
