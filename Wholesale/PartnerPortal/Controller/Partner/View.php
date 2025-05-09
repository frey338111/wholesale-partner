<?php
declare(strict_types=1);

namespace Wholesale\PartnerPortal\Controller\Partner;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;

class View extends Action implements HttpGetActionInterface
{
    public function __construct(
        Context $context
    ) {
        parent::__construct($context);
    }

    /**
     * @inheritDoc
     */
    function execute()
    {
        return $this->resultFactory->create(ResultFactory::TYPE_PAGE);
    }
}


