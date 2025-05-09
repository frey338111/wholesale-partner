<?php
declare(strict_types=1);

namespace Wholesale\PartnerPortal\Controller\Adminhtml\Partner;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\Result\RedirectFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Wholesale\PartnerPortal\Api\PartnerRepositoryInterface;

class Delete extends Action implements HttpPostActionInterface
{
    public const ADMIN_RESOURCE = 'Wholesale_PartnerPortal::edit';

    /**
     * @var PartnerRepositoryInterface
     */
    protected PartnerRepositoryInterface $partnerRepository;

    /**
     * @var RedirectFactory
     */
    protected $resultRedirectFactory;

    public function __construct(
        Context $context,
        PartnerRepositoryInterface $partnerRepository
    ) {
        parent::__construct($context);
        $this->partnerRepository = $partnerRepository;
        $this->resultRedirectFactory = $context->getResultRedirectFactory();
    }

    /**
     * @inheritDoc
     */
    public function execute()
    {
        $id = (int)$this->getRequest()->getParam('id');
        $resultRedirect = $this->resultRedirectFactory->create();
        if (!$id) {
            $this->messageManager->addErrorMessage(__('Unable to find the partner to delete.'));

            return $resultRedirect->setPath('*/*/');
        }
        try {
            $partner = $this->partnerRepository->get($id);
            $this->partnerRepository->delete($partner);
            $this->messageManager->addSuccessMessage(__('Partner was deleted successfully.'));
        } catch (NoSuchEntityException $e) {
            $this->messageManager->addErrorMessage(__('Partner does not exist.'));
        } catch (LocalizedException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(__('Something wrong while deleting the partner.'));
        }

        return $resultRedirect->setPath('*/*/');
    }
}
