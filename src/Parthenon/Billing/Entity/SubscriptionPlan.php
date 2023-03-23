<?php

declare(strict_types=1);

/*
 * Copyright Iain Cambridge 2020-2023.
 *
 * Use of this software is governed by the Business Source License included in the LICENSE file and at https://getparthenon.com/docs/next/license.
 *
 * Change Date: TBD ( 3 years after 2.2.0 release )
 *
 * On the date above, in accordance with the Business Source License, use of this software will be governed by the open source license specified in the LICENSE file.
 */

namespace Parthenon\Billing\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Parthenon\Athena\Entity\CrudEntityInterface;

class SubscriptionPlan implements CrudEntityInterface
{
    private $id;

    private bool $public = false;

    private string $name;

    private ?string $externalReference = null;

    private ?string $externalReferenceLink = null;

    private array|Collection $limits;

    private bool $perSeat;

    private bool $free;

    private int $userCount;

    private array|Collection $features;

    public function __construct()
    {
        $this->limits = new ArrayCollection();
        $this->features = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    public function isPublic(): bool
    {
        return $this->public;
    }

    public function setPublic(bool $public): void
    {
        $this->public = $public;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getExternalReference(): ?string
    {
        return $this->externalReference;
    }

    public function setExternalReference(string $externalReference): void
    {
        $this->externalReference = $externalReference;
    }

    public function hasExternalReference(): bool
    {
        return isset($this->externalReference);
    }

    public function getExternalReferenceLink(): ?string
    {
        return $this->externalReferenceLink;
    }

    public function setExternalReferenceLink(?string $externalReferenceLink): void
    {
        $this->externalReferenceLink = $externalReferenceLink;
    }

    public function getLimits(): Collection|array
    {
        return $this->limits;
    }

    /**
     * @param SubscriptionPlanLimit[]|Collection $limits
     */
    public function setLimits(Collection|array $limits): void
    {
        $this->limits = $limits;
    }

    public function addLimit(SubscriptionPlanLimit $limit): void
    {
        if (!$this->limits->contains($limit)) {
            $limit->setSubscriptionPlan($this);
            $this->limits->add($limit);
        }
    }

    public function removeLimit(SubscriptionPlanLimit $limit): void
    {
        $this->limits->removeElement($limit);
    }

    public function getDisplayName(): string
    {
        return $this->name;
    }

    public function isPerSeat(): bool
    {
        return $this->perSeat;
    }

    public function setPerSeat(bool $perSeat): void
    {
        $this->perSeat = $perSeat;
    }

    public function isFree(): bool
    {
        return $this->free;
    }

    public function setFree(bool $free): void
    {
        $this->free = $free;
    }

    public function getUserCount(): int
    {
        return $this->userCount;
    }

    public function setUserCount(int $userCount): void
    {
        $this->userCount = $userCount;
    }

    public function getFeatures(): Collection|array
    {
        return $this->features;
    }

    public function setFeatures(Collection|array $features): void
    {
        $this->features = $features;
    }
}
