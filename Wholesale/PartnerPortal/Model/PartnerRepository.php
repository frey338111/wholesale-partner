<?php
declare(strict_types=1);

namespace Wholesale\PartnerPortal\Model;

use Exception;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Wholesale\PartnerPortal\Api\PartnerRepositoryInterface;
use Wholesale\PartnerPortal\Api\Data\PartnerInterface;
use Wholesale\PartnerPortal\Model\ResourceModel\Partner as ResourceModel;
use Wholesale\PartnerPortal\Model\ResourceModel\Partner\CollectionFactory;
use Wholesale\PartnerPortal\Reusable\RepositoryTrait;

class PartnerRepository implements PartnerRepositoryInterface
{
    use RepositoryTrait;

    /**
     * @var PartnerFactory partner model factory
     */
    protected PartnerFactory $modelFactory;

    /**
     * @var CollectionFactory partner model collection factory
     */
    protected CollectionFactory $collectionFactory;

    /**
     * @var ResourceModel partner resource model
     */
    protected ResourceModel $modelResource;

    public function __construct(
        PartnerFactory $modelFactory,
        CollectionFactory $collectionFactory,
        ResourceModel $modelResource
    ) {
        $this->modelFactory = $modelFactory;
        $this->collectionFactory = $collectionFactory;
        $this->modelResource = $modelResource;
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
    public function getList(SearchCriteriaInterface $searchCriteria = null): array
    {
        $collection = $this->collectionFactory->create();
        if ($searchCriteria) {
            $this->addFiltersToCollection($searchCriteria, $collection);
            $this->addSortOrdersToCollection($searchCriteria, $collection);
            $this->addPagingToCollection($searchCriteria, $collection);
        }

        return $collection->getItems();
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
