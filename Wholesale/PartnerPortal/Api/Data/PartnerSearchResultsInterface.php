<?php
declare(strict_types=1);

namespace Wholesale\PartnerPortal\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface PartnerSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get list of partners.
     *
     * @return PartnerInterface[]
     */
    public function getItems();

    /**
     * Set list of partners.
     *
     * @param PartnerInterface[] $items
     *                                 
     * @return $this
     */
    public function setItems(array $items);
}
