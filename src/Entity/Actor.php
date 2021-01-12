<?php

namespace App\Entity;

use App\Repository\ActorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=ActorRepository::class)
 * @Vich\Uploadable
 */
class Actor
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $poster = null;

    /**
     * @ORM\ManyToMany(targetEntity=Program::class, inversedBy="actors")
     */
    private $programs;
    /**
     * @Vich\UploadableField(mapping="poster_file", fileNameProperty="poster")
     * @var File
     * @Assert\File(
     *      maxSize="100000",
     *     mimeTypes={"image/jpeg", "image/png", "image/jpg"},
     * )
     */
    private ?File $posterFile = null;

    /**
     * @ORM\Column(type="datetime")
     */
    private ?\DateTime $updatedAt;

    public function __construct()
    {
        $this->programs = new ArrayCollection();
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

    /**
     * @return Collection|Program[]
     */
    public function getPrograms(): Collection
    {
        return $this->programs;
    }

    public function addProgram(Program $program): self
    {
        if (!$this->programs->contains($program)) {
            $this->programs[] = $program;
        }

        return $this;
    }

    public function removeProgram(Program $program): self
    {
        $this->programs->removeElement($program);

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime $updatedAt
     */
    public function setUpdatedAt(\DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
    /**
     * @return File
     */
    public function getPosterFile(): ?File
    {
        return $this->posterFile;
    }

    /**
     * @param File|null $image
     * @return Actor
     */
    public function setPosterFile(File $image = null): ?Actor
    {
        $this->posterFile = $image;
        if ($image) {
            $this->updatedAt = new \DateTime('now');
        }
        return $this;
    }
    /**
     * @return string|null
     */
    public function getPoster(): ?string
    {
        return $this->poster;
    }

    /**
     * @param string|null $poster
     */
    public function setPoster(?string $poster): void
    {
        $this->poster = $poster;
    }
}
