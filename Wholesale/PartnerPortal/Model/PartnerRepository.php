<?php
declare(strict_types=1);

namespace Wholesale\PartnerPortal\Model;

use Exception;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Wholesale\PartnerPortal\Api\PartnerRepositoryInterface;
use Wholesale\PartnerPortal\Api\Data\PartnerInterface;
use Wholesale\PartnerPortal\Api\Data\PartnerSearchResultsInterface;
use Wholesale\PartnerPortal\Api\Data\PartnerSearchResultsInterfaceFactory;
use Wholesale\PartnerPortal\Model\ResourceModel\Partner as ResourceModel;
use Wholesale\PartnerPortal\Model\ResourceModel\Partner\CollectionFactory;

class PartnerRepository implements PartnerRepositoryInterface
{
    /**
     * @var PartnerFactory
     */
    protected PartnerFactory $modelFactory;

    /**
     * @var CollectionFactory
     */
    protected CollectionFactory $collectionFactory;

    /**
     * @var CollectionProcessorInterface
     */
    protected CollectionProcessorInterface $collectionProcessor;

    /**
     * @var PartnerSearchResultsInterfaceFactory
     */
    protected PartnerSearchResultsInterfaceFactory $searchResultsFactory;

    /**
     * @var ResourceModel partner resource model
     */
    protected ResourceModel $modelResource;

    public function __construct(
        PartnerFactory $modelFactory,
        CollectionFactory $collectionFactory,
        ResourceModel $modelResource,
        CollectionProcessorInterface $collectionProcessor,
        PartnerSearchResultsInterfaceFactory $searchResultsFactory
    ) {
        $this->modelFactory = $modelFactory;
        $this->collectionFactory = $collectionFactory;
        $this->modelResource = $modelResource;
        $this->collectionProcessor = $collectionProcessor;
        $this->searchResultsFactory = $searchResultsFactory;
    }

    /**
     * @inheritDoc
     */
    public function save(PartnerInterface $model): PartnerInterface
    {
        try {
            $this->modelResource->save($model);
        } catch (Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }

        return $model;
    }

    /**
     * @inheritDoc
     */
    public function getList(SearchCriteriaInterface $searchCriteria = null): PartnerSearchResultsInterface
    {
        $collection = $this->collectionFactory->create();
        $this->collectionProcessor->process($searchCriteria, $collection);
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());
        $searchResults->setSearchCriteria($searchCriteria);

        return $searchResults;
    }

    /**
     * @inheritDoc
     */
    public function getSingle(SearchCriteriaInterface $searchCriteria = null): ?PartnerInterface
    {
        $result = $this->getList($searchCriteria);
        if ($result->getTotalCount() == 0) {
            return null;
        }
        $items = $result->getItems();

        return $items ? reset($items) : null;
    }

    /**
     * @inheritDoc
     */
    public function get(int $id): PartnerInterface
    {
        /** @var PartnerInterface $model */
        $model = $this->modelFactory->create();
        $this->modelResource->load($model, $id);

        return $model;
    }

    /**
     * @inheritDoc
     */
    public function delete(PartnerInterface $model): bool
    {
        $this->modelResource->delete($model);

        return $model->isDeleted();
    }
}
