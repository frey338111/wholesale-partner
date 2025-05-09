<?php
declare(strict_types=1);

namespace Wholesale\PartnerPortal\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\AlreadyExistsException;
use Magento\Framework\Exception\CouldNotSaveException;
use Wholesale\PartnerPortal\Api\Data\PartnerInterface;

interface PartnerRepositoryInterface
{
    /**
     * Get model by ID
     *
     * @param int $id
     *
     * @return PartnerInterface
     */
    public function get(int $id): PartnerInterface;

    /**
     * Save model
     *
     * @param PartnerInterface $model
     *
     * @return PartnerInterface
     *
     * @throws AlreadyExistsException
     * @throws CouldNotSaveException
     */
    public function save(PartnerInterface $model): PartnerInterface;

    /**
     * Delete model
     *
     * @param PartnerInterface $model
     *
     * @return bool
     *
     * @throws \Throwable
     */
    public function delete(PartnerInterface $model): bool;

    /**
     * Get models by criteria
     *
     * @param SearchCriteriaInterface|null $searchCriteria
     *
     * @return array
     */
    public function getList(SearchCriteriaInterface $searchCriteria = null): array;
}
