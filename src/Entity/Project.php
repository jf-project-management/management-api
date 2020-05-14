<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProjectRepository")
 */
class Project
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Epic", mappedBy="project")
     */
    private $epics;

    public function __construct()
    {
        $this->epics = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|Epic[]
     */
    public function getEpics(): Collection
    {
        return $this->epics;
    }

    public function addEpic(Epic $epic): self
    {
        if (!$this->epics->contains($epic)) {
            $this->epics[] = $epic;
            $epic->setProject($this);
        }

        return $this;
    }

    public function removeEpic(Epic $epic): self
    {
        if ($this->epics->contains($epic)) {
            $this->epics->removeElement($epic);
            // set the owning side to null (unless already changed)
            if ($epic->getProject() === $this) {
                $epic->setProject(null);
            }
        }

        return $this;
    }
}
