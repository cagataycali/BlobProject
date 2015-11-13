<?php

namespace Blob\Core\LibraryBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * BildirimTur
 *
 * @ORM\Table(name="bildirim_turleri")
 * @ORM\Entity
 */
class BildirimTur
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="baslik", type="string", length=255)
     */
    private $baslik;

    /**
     * @ORM\OneToMany(targetEntity="BildirimSablon", mappedBy="tur")
     */
    protected $sablon;

    public function __toString()
    {
        return (string) $this->getBaslik();
    }

    public function __construct()
    {
        $this->sablon = new ArrayCollection();
    }


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set baslik
     *
     * @param string $baslik
     *
     * @return BildirimTur
     */
    public function setBaslik($baslik)
    {
        $this->baslik = $baslik;

        return $this;
    }

    /**
     * Get baslik
     *
     * @return string
     */
    public function getBaslik()
    {
        return $this->baslik;
    }

    /**
     * Add sablon
     *
     * @param \Blob\Core\LibraryBundle\Entity\BildirimSablon $sablon
     *
     * @return BildirimTur
     */
    public function addSablon(\Blob\Core\LibraryBundle\Entity\BildirimSablon $sablon)
    {
        $this->sablon[] = $sablon;

        return $this;
    }

    /**
     * Remove sablon
     *
     * @param \Blob\Core\LibraryBundle\Entity\BildirimSablon $sablon
     */
    public function removeSablon(\Blob\Core\LibraryBundle\Entity\BildirimSablon $sablon)
    {
        $this->sablon->removeElement($sablon);
    }

    /**
     * Get sablon
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSablon()
    {
        return $this->sablon;
    }
}
