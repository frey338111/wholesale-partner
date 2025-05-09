<?php
declare(strict_types=1);

namespace Wholesale\PartnerPortal\Controller\Adminhtml\Partner;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Filesystem;
use Magento\Framework\Image\AdapterFactory;
use Magento\Framework\UrlInterface;
use Magento\MediaStorage\Model\File\UploaderFactory;
use Wholesale\PartnerPortal\Reusable\UrlTrait;

class Upload extends Action implements HttpPostActionInterface
{
    use UrlTrait;
    public const ADMIN_RESOURCE = 'Wholesale_PartnerPortal::edit';

    /**
     * @var JsonFactory
     */
    protected JsonFactory $jsonFactory;

    /**
     * @var UploaderFactory
     */
    protected UploaderFactory $uploaderFactory;

    /**
     * @var Filesystem
     */
    protected Filesystem $filesystem;

    /**
     * @var AdapterFactory
     */
    protected AdapterFactory $adapterFactory;

    public function __construct(
        Context $context,
        JsonFactory $jsonFactory,
        UploaderFactory $uploaderFactory,
        Filesystem $filesystem,
        AdapterFactory $adapterFactory
    ) {
        parent::__construct($context);
        $this->jsonFactory = $jsonFactory;
        $this->uploaderFactory = $uploaderFactory;
        $this->filesystem = $filesystem;
        $this->adapterFactory = $adapterFactory;
    }

    /**
     * @inheritDoc
     */
    public function execute()
    {
        $result = $this->jsonFactory->create();
        try {
            $uploader = $this->uploaderFactory->create(['fileId' => 'logo']);
            $uploader->setAllowedExtensions([
                'jpg',
                'jpeg',
                'png',
                'gif',
                'svg',
            ]);
            $uploader->setAllowRenameFiles(true);
            $uploader->setFilesDispersion(false);
            $mediaDirectory = $this->filesystem->getDirectoryWrite(DirectoryList::MEDIA);
            $target = $mediaDirectory->getAbsolutePath($this->getLogoImageSavePath());
            $resultData = $uploader->save($target);
            if (!$resultData) {
                throw new LocalizedException(__('File upload failed.'));
            }
            $fileName = $resultData['file'];
            $fileUrl = $this->_url->getBaseUrl(['_type' => UrlInterface::URL_TYPE_MEDIA]) . '/' . ltrim($fileName, '/');

            return $result->setData([
                'name' => $fileName,
                'url'  => $fileUrl,
                'type' => $resultData['type'],
                'size' => $resultData['size'],
            ]);
        } catch (\Exception $e) {
            return $result->setData([
                'error' => $e->getMessage(),
                'errorcode' => $e->getCode(),
            ]);
        }
    }
}
