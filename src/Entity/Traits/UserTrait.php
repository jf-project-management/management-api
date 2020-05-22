<?php

namespace App\Entity\Traits;

use App\Entity\User;

trait UserTrait
{
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="projects")
     */
    private $createdBy;

    public function getCreatedBy(): ?User
    {
        return $this->createdBy;
    }

    public function setCreatedBy(?User $createdBy): self
    {
        $this->createdBy = $createdBy;
        return $this;
    }
}