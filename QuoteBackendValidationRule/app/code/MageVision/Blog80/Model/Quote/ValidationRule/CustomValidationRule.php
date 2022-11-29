<?php
/**
 * MageVision Blog80
 *
 * @category     MageVision
 * @package      MageVision_Blog80
 * @author       MageVision Team
 * @copyright    Copyright (c) 2022 MageVision (https://www.magevision.com)
 * @license      http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

declare(strict_types=1);

namespace MageVision\Blog80\Model\Quote\ValidationRule;

use Magento\Framework\Validation\ValidationResultFactory;
use Magento\Quote\Model\Quote;
use Magento\Quote\Model\ValidationRules\QuoteValidationRuleInterface;

class CustomValidationRule implements QuoteValidationRuleInterface
{
    /**
     * @var ValidationResultFactory
     */
    private $validationResultFactory;

    /**
     * @param ValidationResultFactory $validationResultFactory
     */
    public function __construct(
        ValidationResultFactory $validationResultFactory,
    ) {
        $this->validationResultFactory = $validationResultFactory;
    }

    /**
     * @inheritdoc
     *
     * @param Quote $quote
     * @return array
     */
    public function validate(Quote $quote): array
    {
        $validationErrors = [];

        if ($quote->isVirtual()) {
            $validationErrors[] = __(
                'Quote is Virtual!'
            );
        }

        return [$this->validationResultFactory->create(['errors' => $validationErrors])];
    }
}
