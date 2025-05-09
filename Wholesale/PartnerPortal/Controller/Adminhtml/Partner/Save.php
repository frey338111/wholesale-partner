<?php
declare(strict_types=1);

namespace Wholesale\PartnerPortal\Controller\Adminhtml\Partner;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Wholesale\PartnerPortal\Api\Data\PartnerInterfaceFactory;
use Wholesale\PartnerPortal\Api\PartnerRepositoryInterface;
use Wholesale\PartnerPortal\Reusable\UrlTrait;

class Save extends Action implements HttpPostActionInterface
{
    use UrlTrait;

    public const ADMIN_RESOURCE = 'Wholesale_PartnerPortal::edit';

    /**
     * @var PartnerRepositoryInterface
     */
    protected PartnerRepositoryInterface $partnerRepository;

    /**
     * @var PartnerInterfaceFactory
     */
    protected PartnerInterfaceFactory $partnerFactory;

    public function __construct(
        Context $context,
        PartnerRepositoryInterface $partnerRepository,
        PartnerInterfaceFactory $partnerFactory
    ) {
        parent::__construct($context);
        $this->partnerRepository = $partnerRepository;
        $this->partnerFactory = $partnerFactory;
    }

    /**
     * @inheritDoc
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        if (!$data) {
            $this->messageManager->addErrorMessage(__('No data to save.'));

            return $this->_redirect('*/*/');
        }
        try {
            $id = $this->getRequest()->getParam('entity_id');
            $partner = $id ? $this->partnerRepository->get((int)$id) : $this->partnerFactory->create();
            $partner->setName($data['name'] ?? '');
            $partner->setSlug($data['slug'] ?? '');
            if (isset($data['logo'][0]['name'])) {
                $partner->setLogo($this->getLogoImageSavePath() . '/' . ltrim($data['logo'][0]['name'], '/'));
            } else {
                $partner->setLogo(null);
            }
            $this->partnerRepository->save($partner);
            $this->messageManager->addSuccessMessage(__('Partner saved successfully.'));

            return $this->_redirect('*/*/');
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(__('Error: ') . $e->getMessage());

            return $this->_redirect('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
        }
    }
}
