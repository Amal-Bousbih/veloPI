<?php

namespace AppBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Location
 *
 * @ORM\Table(name="location")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\LocationRepository")
 */
class Location
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var DateTime
     * @Assert\DateTime()
     * @Assert\Type(type="DateTime")
     * @ORM\Column(name="datedebut", type="date")
     */
    private $datedebut;


    /**
     * @var DateTime
     * @Assert\DateTime()
     * @Assert\Type(type="DateTime")
     * @Assert\GreaterThan(propertyPath="datedebut")
     * @ORM\Column(name="datefin", type="date")
     */
    private $datefin;

    /**
     * @return int
     */
    public function getVelo()
    {
        return $this->velo;
    }
    /**
     * @var DateTime
     * @Assert\DateTime()
     * @Assert\Type(type="DateTime")
     * @Assert\GreaterThan(propertyPath="dateDebut")
     * @ORM\Column(name="datefin", type="date")
     */

    /**
     * @param int $velo
     */
    public function setVelo($velo)
    {
        $this->velo = $velo;
    }
    /**
     * @ORM\ManyToOne(targetEntity="Zone")
     * @ORM\JoinColumn(name="zone", referencedColumnName="id",  onDelete="cascade")
     */
   private $zone;
    /**
     * @ORM\ManyToOne(targetEntity="Velo")
     * @ORM\JoinColumn(name="velo", referencedColumnName="idz", onDelete="cascade")
     */
    private $velo;

    /**
     * @return int
     */
    public function getZone()
    {
        return $this->zone;
    }

    /**
     * @param int $zone
     */
    public function setZone($zone)
    {
        $this->zone = $zone;
    }
    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set datedebut
     *
     * @param \DateTime $datedebut
     *
     * @return Location
     */
    public function setDatedebut($datedebut)
    {
        $this->datedebut = $datedebut;

        return $this;
    }

    /**
     * Get datedebut
     *
     * @return \DateTime
     */
    public function getDatedebut()
    {
        return $this->datedebut;
    }

    /**
     * Set datefin
     *
     * @param \DateTime $datefin
     *
     * @return Location
     */
    public function setDatefin($datefin)
    {
        $this->datefin = $datefin;

        return $this;
    }

    /**
     * Get datefin
     *
     * @return \DateTime
     */
    public function getDatefin()
    {
        return $this->datefin;
    }
}
