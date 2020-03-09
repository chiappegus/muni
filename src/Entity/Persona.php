<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PersonaRepository")
 */
class Persona
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
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

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getApellido(): ?string
    {
        return $this->apellido;
    }

    public function setApellido(string $apellido): self
    {
        $this->apellido = $apellido;

        return $this;
    }

 

    public function __toString()
    {
       
        
        return  $this->apellido ." ". $this->nombre;

        
    }


    public function getDni(): ?int
    {
        return $this->dni;
    }

    public function setDni(int $dni): self
    {
        $this->dni = $dni;

        return $this;
    }

    public function getIntendente(): ?Intendente
    {
        return $this->intendente;
    }

    public function setIntendente(Intendente $intendente): self
    {
        $this->intendente = $intendente;

        // set the owning side of the relation if necessary
        if ($intendente->getRelation() !== $this) {
            $intendente->setRelation($this);
        }

        return $this;
    }
}
