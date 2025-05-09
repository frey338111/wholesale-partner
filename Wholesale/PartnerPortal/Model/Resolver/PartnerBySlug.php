<?php
declare(strict_types=1);

namespace Wholesale\PartnerPortal\Model\Resolver;

use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Wholesale\PartnerPortal\Api\PartnerRepositoryInterface;

class PartnerBySlug implements ResolverInterface
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
        if (empty($args['slug'])) {
            throw new GraphQlInputException(__('Slug is required.'));
        }
        $criteria = $this->searchCriteriaBuilder
            ->addFilter('slug', $args['slug'])
            ->setPageSize(1)
            ->create();
        $target = $this->partnerRepository->getSingle($criteria);

        return $target?->getData();
    }
}
