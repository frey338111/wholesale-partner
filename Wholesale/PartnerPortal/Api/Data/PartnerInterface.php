<?php
declare(strict_types=1);

namespace Wholesale\PartnerPortal\Api\Data;

interface PartnerInterface
{
    public const ENTITY_ID = "entity_id";
    public const NAME = "name";
    public const SLUG = "slug";
    public const LOGO = "logo";

    /**
     * Getter for EntityId.
     *
     * @return int|null
     */
    public function getEntityId(): ?int;

    /**
     * Setter for EntityId.
     *
     * @param int $entityId
     *
     * @return $this
     */
    public function setEntityId(int $entityId): PartnerInterface;

    /**
     * Getter for Name.
     *
     * @return string|null
     */
    public function getName(): ?string;

    /**
     * Setter for Name.
     *
     * @param string|null $name
     *
     * @return PartnerInterface
     */
    public function setName(?string $name): PartnerInterface;

    /**
     * Getter for Slug.
     *
     * @return string|null
     */
    public function getSlug(): ?string;

    /**
     * Setter for Slug.
     *
     * @param string|null $slug
     *
     * @return PartnerInterface
     */
    public function setSlug(?string $slug): PartnerInterface;

    /**
     * Getter for Logo.
     *
     * @return string|null
     */
    public function getLogo(): ?string;

    /**
     * Setter for Logo.
     *
     * @param string|null $logo
     *
     * @return PartnerInterface
     */
    public function setLogo(?string $logo): PartnerInterface;
}
