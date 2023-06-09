<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\Controller\IndustryController;
use App\Repository\CompanyRepository;
use App\Traites\SourceEntityTrait;
use App\Traites\TimeStampEntityTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CompanyRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[ApiResource(
    operations: [
        new GetCollection(
            uriTemplate: '/companies/industry',
            controller: IndustryController::class,
            openapiContext: [
                'parameters' => [],
            ],
            name: 'industry'
        ),
        new Get(normalizationContext: ['groups' => ['company:get:unit', 'contact:get:unit']]),
        new GetCollection(normalizationContext: ['groups' => ['company:get:list']]),
    ],
    paginationItemsPerPage: 3
)]
#[ApiFilter(SearchFilter::class, properties: ['industry' => 'partial'])]
class Company
{
    use TimeStampEntityTrait;
    use SourceEntityTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['company:get:list', 'company:get:unit'])]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['company:get:list', 'company:get:unit'])]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['company:get:list', 'company:get:unit'])]
    private ?string $industry = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['company:get:list', 'company:get:unit'])]
    private ?string $city = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['company:get:list', 'company:get:unit'])]
    private ?string $country = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['company:get:list', 'company:get:unit'])]
    private ?string $website = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['company:get:list', 'company:get:unit'])]
    private ?string $phone = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['company:get:list', 'company:get:unit'])]
    private ?string $zip = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['company:get:list', 'company:get:unit'])]
    private ?int $numberOfEmployees = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['company:get:list', 'company:get:unit'])]
    private ?string $annualRevenue = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['company:get:list', 'company:get:unit'])]
    private ?string $description = null;

    #[ORM\OneToMany(mappedBy: 'company', targetEntity: Contact::class, orphanRemoval: true)]
    #[Groups(['company:get:unit'])]
    private Collection $contacts;

    public function __construct()
    {
        $this->contacts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getIndustry(): ?string
    {
        return $this->industry;
    }

    public function setIndustry(?string $industry): self
    {
        $this->industry = $industry;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(?string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getWebsite(): ?string
    {
        return $this->website;
    }

    public function setWebsite(?string $website): self
    {
        $this->website = $website;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getZip(): ?string
    {
        return $this->zip;
    }

    public function setZip(?string $zip): self
    {
        $this->zip = $zip;

        return $this;
    }

    public function getNumberOfEmployees(): ?int
    {
        return $this->numberOfEmployees;
    }

    public function setNumberOfEmployees(?int $numberOfEmployees): self
    {
        $this->numberOfEmployees = $numberOfEmployees;

        return $this;
    }

    public function getAnnualRevenue(): ?string
    {
        return $this->annualRevenue;
    }

    public function setAnnualRevenue(?string $annualRevenue): self
    {
        $this->annualRevenue = $annualRevenue;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, Contact>
     */
    public function getContacts(): Collection
    {
        return $this->contacts;
    }

    public function addContact(Contact $contact): self
    {
        if (!$this->contacts->contains($contact)) {
            $this->contacts->add($contact);
            $contact->setCompany($this);
        }

        return $this;
    }

    public function removeContact(Contact $contact): self
    {
        if ($this->contacts->removeElement($contact)) {
            // set the owning side to null (unless already changed)
            if ($contact->getCompany() === $this) {
                $contact->setCompany(null);
            }
        }

        return $this;
    }


}
