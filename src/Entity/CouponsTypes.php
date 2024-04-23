<?php

namespace App\Entity;

use App\Repository\CouponsTypesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CouponsTypesRepository::class)]
class CouponsTypes
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'coupons_types', targetEntity: Coupons::class, orphanRemoval: true)]
    private Collection $ManyToOne;

    public function __construct()
    {
        $this->ManyToOne = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Coupons>
     */
    public function getManyToOne(): Collection
    {
        return $this->ManyToOne;
    }

    public function addManyToOne(Coupons $manyToOne): static
    {
        if (!$this->ManyToOne->contains($manyToOne)) {
            $this->ManyToOne->add($manyToOne);
            $manyToOne->setCouponsTypes($this);
        }

        return $this;
    }

    public function removeManyToOne(Coupons $manyToOne): static
    {
        if ($this->ManyToOne->removeElement($manyToOne)) {
            // set the owning side to null (unless already changed)
            if ($manyToOne->getCouponsTypes() === $this) {
                $manyToOne->setCouponsTypes(null);
            }
        }

        return $this;
    }
}
