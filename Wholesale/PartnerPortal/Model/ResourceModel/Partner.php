<?php
declare(strict_types=1);

namespace Wholesale\PartnerPortal\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Partner extends AbstractDb
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'wholesale_partner_resource_model';

    /**
     * Initialize resource model.
     */
    protected function _construct()
    {
        $this->_init('wholesale_partners', 'entity_id');
        $this->_useIsObjectNew  = true;
    }
}
