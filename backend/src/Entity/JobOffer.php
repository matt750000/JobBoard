<?php

namespace App\Entity;

use App\Enum\TypeContrat;
use App\Repository\JobOfferRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Metadata as Api;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: JobOfferRepository::class)]
#[Api\ApiResource(
    normalizationContext: ['groups' => ['jobOffer_read']],
    denormalizationContext: ['groups' => ['jobOffer_write']],
    security: 'is_granted("ROLE_RECRUTEUR")',
)]
#[Api\Get()]
#[Api\GetCollection()]
#[Api\Post()]
#[Api\Patch()]
#[Api\Delete()]
class JobOffer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['jobOffer_read'])]
    private ?int $id = null;

    #[ORM\Column(length: 150)]
    #[Assert\NotBlank(message: "Job title is required.")]
    #[Groups(['jobOffer_read', 'jobOffer_write'])]
    private ?string $title = null;

    #[ORM\Column(type: 'text')]
    #[Assert\NotBlank(message: "Job description is required.")]
    #[Groups(['jobOffer_read', 'jobOffer_write'])]
    private ?string $description = null;

    #[ORM\Column(length: 50)]
    #[Groups(['jobOffer_read', 'jobOffer_write'])]
    private ?string $typeContrat = null;

    #[ORM\Column(nullable: true)]
    #[Assert\Positive(message: "Salary must be a positive number.")]
    #[Groups(['jobOffer_read', 'jobOffer_write'])]
    private ?int $salary = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank(message: "Location is required.")]
    #[Groups(['jobOffer_read', 'jobOffer_write'])]
    private ?string $location = null;

    #[ORM\Column]
    #[Groups(['jobOffer_read'])]
    private ?\DateTimeImmutable $publishedAt = null;

    /**
     * @var Collection<int, Application>
     */
    #[ORM\OneToMany(targetEntity: Application::class, mappedBy: 'jobOffer', orphanRemoval: true)]
    private Collection $applications;

    #[ORM\ManyToOne(inversedBy: 'jobOffers')]
    #[ORM\JoinColumn(onDelete: 'CASCADE', nullable: false)]
    #[Groups(['jobOffer_read'])]
    private ?Company $company = null;

    public function __construct()
    {
        $this->applications = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;
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

    public function getTypeContrat(): ?TypeContrat
    {
        return $this->typeContrat !== null ? TypeContrat::from($this->typeContrat) : null;
    }

    public function setTypeContrat(TypeContrat $typeContrat): self
    {
        $this->typeContrat = $typeContrat->value;
        return $this;
    }

    public function getSalary(): ?int
    {
        return $this->salary;
    }

    public function setSalary(?int $salary): self
    {
        $this->salary = $salary;
        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): self
    {
        $this->location = $location;
        return $this;
    }

    public function getPublishedAt(): ?\DateTimeImmutable
    {
        return $this->publishedAt;
    }

    public function setPublishedAt(\DateTimeImmutable $publishedAt): self
    {
        $this->publishedAt = $publishedAt;
        return $this;
    }

    public function __toString(): string
    {
        return $this->getTitle();
    }

    /**
     * @return Collection<int, Application>
     */
    public function getApplications(): Collection
    {
        return $this->applications;
    }

    public function addApplication(Application $application): static
    {
        if (!$this->applications->contains($application)) {
            $this->applications->add($application);
            $application->setJobOffer($this);
        }

        return $this;
    }

    public function removeApplication(Application $application): static
    {
        if ($this->applications->removeElement($application)) {
            // set the owning side to null (unless already changed)
            if ($application->getJobOffer() === $this) {
                $application->setJobOffer(null);
            }
        }

        return $this;
    }

    public function getCompany(): ?Company
    {
        return $this->company;
    }

    public function setCompany(?Company $company): static
    {
        $this->company = $company;

        return $this;
    }
}
