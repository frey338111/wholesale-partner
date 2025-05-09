<?php
declare(strict_types=1);

namespace Wholesale\PartnerPortal\Controller;

use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\App\ActionFactory;
use Magento\Framework\App\ActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\RouterInterface;
use Wholesale\PartnerPortal\Api\PartnerRepositoryInterface;
use Wholesale\PartnerPortal\Reusable\UrlTrait;

class Router implements RouterInterface
{
    use UrlTrait;

    protected const BASE_PATH = 'wholesale/partner';

    /**
     * @var ActionFactory
     */
    protected ActionFactory $actionFactory;

    /**
     * @var PartnerRepositoryInterface
     */
    protected PartnerRepositoryInterface $partnerRepository;

    /**
     * @var SearchCriteriaBuilder
     */
    protected SearchCriteriaBuilder $criteriaBuilder;

    public function __construct(
        ActionFactory $actionFactory,
        PartnerRepositoryInterface $partnerRepository,
        SearchCriteriaBuilder $criteriaBuilder
    ) {
        $this->actionFactory = $actionFactory;
        $this->partnerRepository = $partnerRepository;
        $this->criteriaBuilder = $criteriaBuilder;
    }

    /**
     * @inheritDoc
     */
    public function match(RequestInterface $request): ?ActionInterface
    {
        $pathInfo = \trim($request->getPathInfo(), '/');
        if (!$this->isValidPath(self::BASE_PATH, $pathInfo)) {
            return null;
        }

        return $this->forwardToPartnerPage($pathInfo, $request);
    }

    /**
     * Forward to partner page
     *
     * @param string           $pathInfo
     * @param RequestInterface $request
     *
     * @return ActionInterface
     */
    protected function forwardToPartnerPage(string $pathInfo, RequestInterface $request): ActionInterface
    {
        $action = 'index';
        $request->setModuleName('wholesale')
            ->setControllerName('partner');
        $slug = $this->extractSlug(2, $pathInfo);
        if ($slug) {
            $action = 'view';
        }
        $request->setActionName($action);
        if ($slug) {
            $request->setParam('slug', $slug);
        }

        return $this->actionFactory->create('Magento\Framework\App\Action\Forward');
    }
}
