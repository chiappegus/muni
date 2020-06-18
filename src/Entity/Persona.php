<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PersonaRepository")
 */
class Persona implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(
     *      min = 2,
     *      max = 50,
     *      minMessage = "Your first name must be at least {{ limit }} characters long",
     *      maxMessage = "Your first name cannot be longer than {{ limit }} characters",
     *      allowEmptyString = false
     * )
     */
    private $nombre;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $apellido;

    /**
     * @ORM\Column(type="integer")
     */
    private $dni;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Intendente", mappedBy="relation", cascade={"persist", "remove"})
     */
    private $intendente;
    /*==============================================
    =            recientemente agregado            =
    ==============================================*/
    /**
     *@ORM\Column(type="string" ,  unique=true ,length=40)
     * @Gedmo\Slug(fields={"dni"})
     */
    private $slug;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $imageFilename;

    /**
     * @ORM\Column(type="string", length = 191 ,unique=true )
     */
    private $email;

    /**
     * Get slug
     * @return
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set slug
     * @return $this
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
        return $this;
    }

    /*=====  End of recientemente agregado  ======*/

    public function getId():  ? int
    {
        return $this->id;
    }

    public function getNombre() :  ? string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre) : self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getApellido():  ? string
    {
        return $this->apellido;
    }

    public function setApellido(string $apellido) : self
    {
        $this->apellido = $apellido;

        return $this;
    }

    public function __toString()
    {

        return $this->apellido . " " . $this->nombre;

    }

    public function getDni():  ? int
    {
        return $this->dni;
    }

    public function setDni(int $dni) : self
    {
        $this->dni = $dni;

        return $this;
    }

    public function getIntendente():  ? Intendente
    {
        return $this->intendente;
    }

    public function setIntendente(Intendente $intendente) : self
    {
        $this->intendente = $intendente;

        // set the owning side of the relation if necessary
        if ($intendente->getRelation() !== $this) {
            $intendente->setRelation($this);
        }

        return $this;
    }

    public function getImageFilename():  ? string
    {
        return $this->imageFilename;
    }

    public function setImageFilename( ? string $imageFilename) : self
    {
        $this->imageFilename = $imageFilename;

        return $this;
    }

    public function getPersonaImagePath()
    {
        if ($this->getImageFilename() != "") {

            return 'uploads/persona_image/' . $this->getImageFilename();
        }
    }

    /**
     * @Assert\Callback
     */
    public function validate(ExecutionContextInterface $context, $payload)
    {
        // if (stripos($this->getApellido(), 'Chiappe') !== false) {
        if (stripos($this->getApellido(), 'Chiappe') !== false) {
            $context->buildViolation('Um.. Chiappe hay uno solo')
                ->atPath('apellido')
                ->addViolation();
        }
    }

    /**
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the user object
     * is created.
     * @return (Role|string)[] The user roles
     */
    public function getRoles()
    {

        return ['ROLE_USER'];
        //throw new \Exception('Method getRoles() is not implemented.');
    }

    /**
     * Returns the password used to authenticate the user.
     *
     * This should be the encoded password. On authentication, a plain-text
     * password will be salted, encoded, and then compared to this value.
     *
     * @return string|null The encoded password if any
     */
    public function getPassword()
    {
        //throw new \Exception('Method getPassword() is not implemented.');
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {
        // throw new \Exception('Method getSalt() is not implemented.');
    }

    /**
     * Returns the username used to authenticate the user.
     *
     * @return string The username
     */
    public function getUsername()
    {
        return $this->email;
        //throw new \Exception('Method getUsername() is not implemented.');
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
        // throw new \Exception('Method eraseCredentials() is not implemented.');
    }

    public function getEmail() :  ? string
    {
        return $this->email;
    }

    public function setEmail(string $email) : self
    {
        $this->email = $email;

        return $this;
    }
}
