<?php
declare(strict_types=1);

namespace Wholesale\PartnerPortal\Controller\Adminhtml\Partner;

use Magento\Backend\App\Action;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\ResultFactory;
class Index extends Action implements HttpGetActionInterface
{
    public const ADMIN_RESOURCE = 'Wholesale_PartnerPortal::listing';

    /**
     * @inheritDoc
     */
    public function execute()
    {
        return $this->resultFactory->create(ResultFactory::TYPE_PAGE);
    }
}
