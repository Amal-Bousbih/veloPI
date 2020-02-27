<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Velo
 *
 * @ORM\Table(name="velo")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\VeloRepository")
 */
class Velo
{
    /**
     * @var int
     *
     * @ORM\Column(name="idz", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idz;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="debutservice", type="date")
     */
    private $debutservice;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;

    /**
     * @return bool
     */
    public function isDisponible()
    {
        return $this->disponible;
    }

    /**
     * @param bool $disponible
     */
    public function setDisponible($disponible)
    {
        $this->disponible = $disponible;
    }


    /**
     * @var boolean
     *
     * @ORM\Column(name="disponible", type="boolean", length=255)
     */
    private $disponible;
    /**
     * @var int
     * @ORM\ManyToOne(targetEntity="Zone")
     * @ORM\JoinColumn(name="zone", referencedColumnName="id", onDelete="cascade")
     */
    private $zone;


    /**
     * Get idz
     *
     * @return int
     */
    public function getId()
    {
        return $this->idz;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Velo
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set debutservice
     *
     * @param \DateTime  $debutservice
     *
     * @return Velo
     */
    public function setDebutservice($debutservice)
    {
        $this->debutservice = $debutservice;

        return $this;
    }

    /**
     * Get debutservice
     *
     * @return \DateTime
     */
    public function getDebutservice()
    {
        return $this->debutservice;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return Velo
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }


    /**
     * @param string $zone
     */
    public function setZone($zone)
    {
        $this->zone = $zone;
    }

    /**
     * @return int
     */
    public function getZone()
    {
        return $this->zone;
    }

    /**
     * Get disponible
     *
     * @return boolean
     */
    public function getDisponible()
    {
        return $this->disponible;
    }



    /**
     * Get idz
     *
     * @return integer
     */
    public function getIdz()
    {
        return $this->idz;
    }
}
