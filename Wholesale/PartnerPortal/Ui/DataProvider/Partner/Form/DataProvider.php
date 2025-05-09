<?php
declare(strict_types=1);

namespace Wholesale\PartnerPortal\Ui\DataProvider\Partner\Form;

use Magento\Framework\UrlInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Ui\DataProvider\AbstractDataProvider;
use Wholesale\PartnerPortal\Model\ResourceModel\Partner\CollectionFactory;

class DataProvider extends AbstractDataProvider
{
    /**
     * @var array
     */
    protected array $loadedData = [];

    /**
     * @var StoreManagerInterface
     */
    protected StoreManagerInterface $storeManager;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        StoreManagerInterface $storeManager,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $collectionFactory->create();
        $this->storeManager = $storeManager;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * @inheritDoc
     */
    public function getData(): array
    {
        if (!empty($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        foreach ($items as $item) {
            $data = $item->getData();
            if (!empty($data['logo'])) {
                $mediaUrl = $this->storeManager->getStore()
                    ->getBaseUrl(UrlInterface::URL_TYPE_MEDIA);
                $logoPath = ltrim($data['logo'], '/');
                $data['logo'] = [
                    [
                        'name' => basename($logoPath),
                        'url'  => $mediaUrl . $logoPath,
                    ],
                ];
            }
            $this->loadedData[$item->getId()] = $data;
        }

        return $this->loadedData;
    }
}
