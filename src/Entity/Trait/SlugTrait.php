<?php
 namespace App\Entity\Trait;
 use Doctrine\ORM\Mapping as ORM;

 trait SlugTrait{
    #[ORM\Column(type:'string', length:255)]
    private $slug;

    public function getslug(): ?string
    {
        return $this->slug;
    }

    public function setslug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }
}