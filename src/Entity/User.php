<?php

namespace App\Entity;

use App\Form\GenderType;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\Null_;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use FOS\UserBundle\Model\User as BaseUSer;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class User extends BaseUser implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected $id;

//    /**
//     * @ORM\Column(type="string", unique=true)
//     */
    protected $confirmationToken;

//    /**
//     * @ORM\Column(type="string", length=180, unique=true)
//     */
    protected $email;

//    /**
//     * @ORM\Column(type="json")
//     */
    protected $roles = [];
//
//    /**
//     * @var string The hashed password
//     * @ORM\Column(type="string")
//     */
    protected $password;

    /**
     * @ORM\Column(type="string", length=45)
     */
    private $FIO;


    /**
     * @ORM\Column(type="date")
     */
    private $birthdate;

    /**
     * @ORM\Column(type="string", length=5)
     */
    private $gender;

    /**
     * @ORM\Column(type="string", length=15)
     */
    private $phonenumber;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Training", inversedBy="users")
     */
    private $traininggroup;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     */
    private $notificationtype;


    public function __construct()
    {
        $this->traininggroup = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

//    public function getEmail(): ?string
//    {
//        return $this->email;
//    }
//
//    public function setEmail(string $email): self
//    {
//        $this->email = $email;
//
//        return $this;
//    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFIO(): ?string
    {
        return $this->FIO;
    }

    public function setFIO(string $FIO): self
    {
        $this->FIO = $FIO;

        return $this;
    }

    public function getGender(): ? string
    {
        return $this->gender;
    }

    public function setGender(string $gender): self
    {
        $this->gender= $gender;

        return $this;
    }


    public function getBirthdate(): ?\DateTimeInterface
    {
        return $this->birthdate;
    }

    public function setBirthdate(\DateTimeInterface $birthdate): self
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    public function getPhonenumber(): ?string
    {
        return $this->phonenumber;
    }

    public function setPhonenumber(string $phonenumber): self
    {
        $this->phonenumber = $phonenumber;

        return $this;
    }

    /**
     * @return Collection|training[]
     */
    public function getTraininggroup(): Collection
    {
        return $this->traininggroup;
    }

    public function addTraininggroup(training $traininggroup): self
    {
        if (!$this->traininggroup->contains($traininggroup)) {
            $this->traininggroup[] = $traininggroup;
        }

        return $this;
    }

    public function removeTraininggroup(training $traininggroup): self
    {
        if ($this->traininggroup->contains($traininggroup)) {
            $this->traininggroup->removeElement($traininggroup);
        }

        return $this;
    }

    public function getNotificationtype(): ?int
    {
        return $this->notificationtype;
    }

    public function setNotificationtype(?int $notificationtype): self
    {
        if(!$this->notificationtype or $this->notificationtype == null){
            $this->notificationtype = 0;
        }else {
            $this->notificationtype = $notificationtype;

        }
        return $this;
    }

}
