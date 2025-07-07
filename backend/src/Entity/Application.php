<?php

namespace App\Entity;

use App\Repository\ApplicationRepository;
use App\Enum\ApplicationStatus;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Metadata as Api;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: ApplicationRepository::class)]
#[Api\ApiResource(
    normalizationContext: ['groups' => ['application_read']],
    denormalizationContext: ['groups' => ['application_write']],
    security: 'is_granted("ROLE_RECRUTEUR")',
)]
#[Api\Get()]
#[Api\Post()]
#[Api\Patch()]
#[Api\Delete()]
class Application
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['application_read'])]
    private ?int $id = null;

    #[ORM\Column]
    #[Assert\NotNull(message: "La date de candidature est obligatoire.")]
    #[Groups(['application_read'])]
    private ?\DateTimeImmutable $appliedAt = null;

    #[ORM\Column(length: 20)]
    #[Assert\NotBlank(message: "Le statut est obligatoire.")]
    #[Groups(['application_read', 'application_write'])]
    private ?string $status = null;

    #[ORM\ManyToOne(inversedBy: 'applications')]
    #[ORM\JoinColumn(onDelete: 'CASCADE', nullable: false)]
    #[Groups(['application_read'])]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'applications')]
    #[ORM\JoinColumn(onDelete: 'CASCADE', nullable: false)]
    #[Groups(['application_read', 'application_write'])]
    private ?JobOffer $jobOffer = null;

    public function __construct()
    {
        $this->appliedAt = new \DateTimeImmutable();
        $this->status = ApplicationStatus::EN_ATTENTE->value;
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAppliedAt(): ?\DateTimeImmutable
    {
        return $this->appliedAt;
    }

    public function setAppliedAt(\DateTimeImmutable $appliedAt): self
    {
        $this->appliedAt = $appliedAt;
        return $this;
    }

    public function getStatus(): ?ApplicationStatus
    {
        return $this->status ? ApplicationStatus::from($this->status) : null;
    }

    public function setStatus(ApplicationStatus $status): self
    {
        $this->status = $status->value;
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

    public function getJobOffer(): ?JobOffer
    {
        return $this->jobOffer;
    }

    public function setJobOffer(?JobOffer $jobOffer): static
    {
        $this->jobOffer = $jobOffer;

        return $this;
    }
}
