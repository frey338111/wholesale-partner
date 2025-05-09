<?php
declare(strict_types=1);

namespace Wholesale\PartnerPortal\Model;

use Magento\Framework\Model\AbstractModel;
use Wholesale\PartnerPortal\Model\ResourceModel\Partner as ResourceModel;
use Wholesale\PartnerPortal\Api\Data\PartnerInterface;

class Partner extends AbstractModel implements PartnerInterface
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'wholesale_partner_model';

    /**
     * Initialize magento model.
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(ResourceModel::class);
    }

    /**
     * Getter for EntityId.
     *
     * @return int|null
     */
    public function getEntityId(): ?int
    {
        return $this->getData(self::ENTITY_ID) === null ? null : (int)$this->getData(self::ENTITY_ID);
    }

    /**
     * Setter for EntityId.
     *
     * @param int $entityId
     *
     * @return $this
     */
    public function setEntityId($entityId): PartnerInterface
    {
        return $this->setData(self::ENTITY_ID, $entityId);
    }

    /**
     * Getter for Name.
     *
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->getData(self::NAME);
    }

    /**
     * Setter for Name.
     *
     * @param string|null $name
     *
     * @return $this
     */
    public function setName(?string $name): PartnerInterface
    {
        return $this->setData(self::NAME, $name);
    }

    /**
     * Getter for Slug.
     *
     * @return string|null
     */
    public function getSlug(): ?string
    {
        return $this->getData(self::SLUG);
    }

    /**
     * Setter for Slug.
     *
     * @param string|null $slug
     *
     * @return void
     */
    public function setSlug(?string $slug): PartnerInterface
    {
        return $this->setData(self::SLUG, $slug);
    }

    /**
     * Getter for Logo.
     *
     * @return string|null
     */
    public function getLogo(): ?string
    {
        return $this->getData(self::LOGO);
    }

    /**
     * Setter for Logo.
     *
     * @param string|null $logo
     *
     * @return void
     */
    public function setLogo(?string $logo): PartnerInterface
    {
        return $this->setData(self::LOGO, $logo);
    }
}
