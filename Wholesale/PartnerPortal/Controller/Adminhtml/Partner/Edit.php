<?php
declare(strict_types=1);

namespace Wholesale\PartnerPortal\Controller\Adminhtml\Partner;

use Magento\Backend\App\Action;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\ResultFactory;

class Edit extends Action implements HttpGetActionInterface
{
    public const ADMIN_RESOURCE = 'Wholesale_PartnerPortal::edit';

    /**
     * @inheritDoc
     */
    public function execute()
    {
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $resultPage->getConfig()->getTitle()->prepend(__('Edit Partner'));

        return $resultPage;
    }
}
