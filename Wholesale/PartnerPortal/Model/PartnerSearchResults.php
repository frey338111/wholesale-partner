<?php
declare(strict_types=1);

namespace Wholesale\PartnerPortal\Model;

use Magento\Framework\Api\SearchResults;
use Wholesale\PartnerPortal\Api\Data\PartnerSearchResultsInterface;

class PartnerSearchResults extends SearchResults implements PartnerSearchResultsInterface
{
}
