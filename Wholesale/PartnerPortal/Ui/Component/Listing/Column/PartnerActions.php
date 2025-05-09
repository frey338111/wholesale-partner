<?php
declare(strict_types=1);

namespace Wholesale\PartnerPortal\Ui\Component\Listing\Column;

use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

class PartnerActions extends Column
{
    public const EDIT_URL_PATH = 'wholesale/partner/edit';
    public const DELETE_URL_PATH = 'wholesale/partner/delete';

    /**
     * @var UrlInterface
     */
    protected UrlInterface $urlBuilder;

    public function __construct(
        UrlInterface $urlBuilder,
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        array $components = [],
        array $data = []
    ) {
        $this->urlBuilder = $urlBuilder;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * @inheritDoc
     */
    public function prepareDataSource(array $dataSource): array
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                if (isset($item['entity_id'])) {
                    $editUrl = $this->urlBuilder->getUrl(self::EDIT_URL_PATH, ['id' => $item['entity_id']]);
                    $deleteUrl = $this->urlBuilder->getUrl(self::DELETE_URL_PATH, ['id' => $item['entity_id']]);
                    $item[$this->getData('name')] = [
                        'edit'   => [
                            'href'  => $editUrl,
                            'label' => __('Edit'),
                        ],
                        'delete' => [
                            'href'    => $deleteUrl,
                            'label'   => __('Delete'),
                            'confirm' => [
                                'title'   => __('Delete Partner'),
                                'message' => __('Are you sure you want to delete this partner?'),
                            ],
                            'post'    => true,
                        ],
                    ];
                }
            }
        }

        return $dataSource;
    }
}
