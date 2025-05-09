<?php
declare(strict_types=1);

namespace Wholesale\PartnerPortal\ViewModel;

use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Phrase;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Asset\Repository as AssetRepository;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Store\Model\StoreManagerInterface;
use Wholesale\PartnerPortal\Api\PartnerRepositoryInterface;
use Wholesale\PartnerPortal\Model\Partner;

class PartnerView implements ArgumentInterface
{
    /**
     * @var SearchCriteriaBuilder
     */
    protected SearchCriteriaBuilder $searchCriteriaBuilder;

    /**
     * @var PartnerRepositoryInterface
     */
    protected PartnerRepositoryInterface $partnerRepository;

    /**
     * @var StoreManagerInterface
     */
    protected StoreManagerInterface $storeManager;

    /**
     * @var AssetRepository
     */
    protected AssetRepository $assetRepo;

    /**
     * @var RequestInterface
     */
    protected RequestInterface $request;

    public function __construct(
        SearchCriteriaBuilder $searchCriteriaBuilder,
        PartnerRepositoryInterface $partnerRepository,
        StoreManagerInterface $storeManager,
        AssetRepository $assetRepo,
        RequestInterface $request
    ) {
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->partnerRepository = $partnerRepository;
        $this->storeManager = $storeManager;
        $this->assetRepo = $assetRepo;
        $this->request = $request;
    }

    /**
     * Get Title for Listing page
     *
     * @return Phrase
     */
    public function getListingPageTitle(): Phrase
    {
        return __("Welcome to the Partner Listing Page!");
    }

    /**
     * Get Title for View page
     *
     * @return Phrase
     */
    public function getPartnerViewPageTitle(): Phrase
    {
        return __("Welcome to the Partner View Page!");
    }

    /**
     * Get partner object by slug
     *
     * @return Partner|null
     */
    public function getPartnerBySlug(): ?Partner
    {
        $slug = $this->request->getParam('slug');
        if (!$slug) {
            return null;
        }
        $criteria = $this->searchCriteriaBuilder
            ->addFilter('slug', $slug)
            ->setPageSize(1)
            ->create();
        return $this->partnerRepository->getSingle($criteria);
    }

    /**
     * Get list of partners
     *
     * @return array
     */
    public function getPartnerCollection(): array
    {
        $searchCriteria = $this->searchCriteriaBuilder
            ->setPageSize(0)
            ->create();

        return $this->partnerRepository->getList($searchCriteria)->getItems();
    }

    /**
     * Get logo url
     *
     * @param Partner|null $partner
     *
     * @return string
     * @throws NoSuchEntityException
     */
    public function getLogoUrl(?Partner $partner): string
    {
        if ($partner && $partner->getLogo()) {
            $mediaUrl = $this->storeManager
                ->getStore()
                ->getBaseUrl(UrlInterface::URL_TYPE_MEDIA);

            return $mediaUrl . ltrim($partner->getLogo(), '/');
        }

        // Fallback to placeholder image
        return $this->assetRepo->getUrl('Magento_Catalog::images/product/placeholder/image.jpg');
    }
}
