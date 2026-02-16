<?php

namespace App\Entity;

use App\Repository\CommentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommentRepository::class)]
class Comment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $contenu = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updated_at = null;

    #[ORM\ManyToOne(inversedBy: 'comments')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'comments')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Post $post = null;

    /**
     * @var Collection<int, Signalement>
     */
    #[ORM\OneToMany(targetEntity: Signalement::class, mappedBy: 'comment', orphanRemoval: true)]
    private Collection $signalements;

    public function __construct()
    {
        $this->signalements = new ArrayCollection();
    }

    public function __toString(): string
    {
        return strip_tags($this->getContenu() ?? '');
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): static
    {
        $this->contenu = $contenu;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeImmutable $updated_at): static
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getPost(): ?Post
    {
        return $this->post;
    }

    public function setPost(?Post $post): static
    {
        $this->post = $post;

        return $this;
    }

    /**
     * @return Collection<int, Signalement>
     */
    public function getSignalements(): Collection
    {
        return $this->signalements;
    }

    public function addSignalement(Signalement $signalement): static
    {
        if (!$this->signalements->contains($signalement)) {
            $this->signalements->add($signalement);
            $signalement->setComment($this);
        }

        return $this;
    }

    public function removeSignalement(Signalement $signalement): static
    {
        if ($this->signalements->removeElement($signalement)) {
            // set the owning side to null (unless already changed)
            if ($signalement->getComment() === $this) {
                $signalement->setComment(null);
            }
        }

        return $this;
    }
}
