<?php
declare(strict_types=1);

namespace Wholesale\PartnerPortal\Model\Resolver;

use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Wholesale\PartnerPortal\Api\PartnerRepositoryInterface;

class PartnerSearch implements ResolverInterface
{
    /**
     * @var SearchCriteriaBuilder
     */
    protected SearchCriteriaBuilder $searchCriteriaBuilder;

    /**
     * @var PartnerRepositoryInterface
     */
    protected PartnerRepositoryInterface $partnerRepository;

    public function __construct(
        SearchCriteriaBuilder $searchCriteriaBuilder,
        PartnerRepositoryInterface $partnerRepository
    ) {
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->partnerRepository = $partnerRepository;
    }

    /**
     * @inheritDoc
     */
    public function resolve(
        $field,
        $context,
        ResolveInfo $info,
        array $value = null,
        array $args = null
    ) {
        $currentPage = $args['currentPage'] ?? 1;
        $pageSize = $args['pageSize'] ?? 10;
        $this->searchCriteriaBuilder
            ->setCurrentPage($currentPage)
            ->setPageSize($pageSize);
        if (!empty($args['name'])) {
            $this->searchCriteriaBuilder->addFilter('name', '%' . $args['name'] . '%', 'like');
        }
        $searchCriteria = $this->searchCriteriaBuilder->create();
        $searchResults = $this->partnerRepository->getList($searchCriteria);
        $items = array_map(function ($partner) {
            return $partner->getData();
        }, $searchResults->getItems());

        return [
            'items'        => $items,
            'total_count'  => $searchResults->getTotalCount(),
            'current_page' => $currentPage,
            'page_size'    => $pageSize,
        ];
    }
}

