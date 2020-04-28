<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\MappedSuperclass;

/**
 * @MappedSuperclass
 */
class OrderableEntity
{
    /**
     * @ORM\Column(type="integer")
     */
    private $orderPosition;

    public function getOrderPosition(): ?int
    {
        return $this->orderPosition;
    }

    public function setOrderPosition(int $orderPosition): self
    {
        $this->orderPosition = $orderPosition;
        return $this;
    }
}