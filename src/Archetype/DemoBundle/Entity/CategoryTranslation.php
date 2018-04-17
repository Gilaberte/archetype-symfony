<?php

namespace Archetype\DemoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 */
class CategoryTranslation
{
    use ORMBehaviors\Translatable\Translation;

    /**
     * @Assert\NotNull
     * @Assert\Length(max=255)
     * @ORM\Column(type="string")
     */
    protected $name;

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }
}
