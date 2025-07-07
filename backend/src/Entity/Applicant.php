<?php

namespace App\Entity;

use ApiPlatform\Metadata as Api;
use App\Repository\ApplicantRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: ApplicantRepository::class)]
#[Api\ApiResource(
    normalizationContext: ['groups' => ['applicant_read']],
    denormalizationContext: ['groups' => ['applicant_write']],
)]
#[Api\Post(security: "is_granted('ROLE_USER') and object.getId() == user.getId()")]
#[Api\Patch(security: "is_granted('ROLE_USER') and object.getUser() == user and object.getStatus() != 'ACCEPTEE'")]
#[Api\Delete(security: "is_granted('ROLE_USER') and object.getId() == user.getId()")]
class Applicant
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['applicant_read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['applicant_read', 'applicant_write'])]
    private ?string $cvUrl = null;

    #[ORM\ManyToOne(inversedBy: 'applicants')]
    #[ORM\JoinColumn(onDelete: 'CASCADE', nullable: false)]
    #[Groups(['applicant_read'])]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCvUrl(): ?string
    {
        return $this->cvUrl;
    }

    public function setCvUrl(string $cvUrl): static
    {
        $this->cvUrl = $cvUrl;

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
}
