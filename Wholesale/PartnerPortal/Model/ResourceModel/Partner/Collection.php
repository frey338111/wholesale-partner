<?php
declare(strict_types=1);

namespace Wholesale\PartnerPortal\Model\ResourceModel\Partner;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Wholesale\PartnerPortal\Model\Partner as Model;
use Wholesale\PartnerPortal\Model\ResourceModel\Partner as ResourceModel;

class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'wholesale_partner_collection';

    /**
     * Initialize collection model.
     */
    protected function _construct()
    {
        $this->_init(Model::class, ResourceModel::class);
    }
}
