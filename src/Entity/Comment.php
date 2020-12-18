<?php

namespace App\Entity;

use App\Repository\CommentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=CommentRepository::class)
 */
class Comment
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank
     */
    private ?string $comment;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank
     * @Assert\LessThanOrEqual(value = 5)
     */
    private ?int $rate;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="comments")
     * @ORM\JoinColumn(nullable=false)
     */
    private ?User $author;

    /**
     * @ORM\ManyToOne(targetEntity=Episode::class, inversedBy="comments")
     * @ORM\JoinColumn(nullable=false)
     */
    private ?Episode $episodeId;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    public function getRate(): ?int
    {
        return $this->rate;
    }

    public function setRate(int $rate): self
    {
        $this->rate = $rate;

        return $this;
    }

    public function setAuthor(?User $author): self
    {
        $this->author = $author;

        return $this;
    }
    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function getEpisodeId(): ?Episode
    {
        return $this->episodeId;
    }

    public function setEpisodeId(?Episode $episodeId): self
    {
        $this->episodeId = $episodeId;

        return $this;
    }
}
