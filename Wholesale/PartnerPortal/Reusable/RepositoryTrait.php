<?php
declare(strict_types=1);

namespace Wholesale\PartnerPortal\Reusable;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection as Collection;

trait RepositoryTrait
{
    /**
     * Add filters to collection
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @param Collection              $collection
     */
    protected function addFiltersToCollection(SearchCriteriaInterface $searchCriteria, Collection $collection): void
    {
        foreach ($searchCriteria->getFilterGroups() as $filterGroup) {
            $fields = $conditions = [];

            foreach ($filterGroup->getFilters() as $filter) {
                $fields[] = $filter->getField();
                $conditions[] = [$filter->getConditionType() => $filter->getValue()];
            }

            $collection->addFieldToFilter($fields, $conditions);
        }
    }

    /**
     * Add sort orders to collection
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @param Collection              $collection
     */
    protected function addSortOrdersToCollection(SearchCriteriaInterface $searchCriteria, Collection $collection): void
    {
        if (!$searchCriteria->getSortOrders()) {
            return;
        }

        foreach ($searchCriteria->getSortOrders() as $sortOrder) {
            $direction = $sortOrder->getDirection() === SortOrder::SORT_ASC ? 'asc' : 'desc';
            $collection->addOrder($sortOrder->getField(), $direction);
        }
    }

    /**
     * Add paging to collection
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @param Collection              $collection
     */
    protected function addPagingToCollection(SearchCriteriaInterface $searchCriteria, Collection $collection): void
    {
        $collection->setPageSize($searchCriteria->getPageSize());
        $collection->setCurPage($searchCriteria->getCurrentPage());
    }
}
