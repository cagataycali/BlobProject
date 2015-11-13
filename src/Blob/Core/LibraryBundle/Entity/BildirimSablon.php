<?php

namespace Blob\Core\LibraryBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * BildirimSablon
 *
 * @ORM\Table(name="bildirim_sablonlari")
 * @ORM\Entity
 */
class BildirimSablon
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
     * @ORM\Column(name="icerik", type="string", length=255)
     */
    private $icerik;

    /**
     * @ORM\ManyToOne(targetEntity="BildirimTur", inversedBy="sablon")
     * @ORM\JoinColumn(name="tur_id", referencedColumnName="id",onDelete="CASCADE")
     */
    protected $tur;

    /**
     * @ORM\OneToMany(targetEntity="Bildirim" , mappedBy="sablon")
     */
    private $bildirimler;

    public function __construct()
    {
        $this->bildirimler = new ArrayCollection();
    }

    public function __toString()
    {
        return (string) $this->getIcerik();
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
     * Set icerik
     *
     * @param string $icerik
     *
     * @return BildirimSablon
     */
    public function setIcerik($icerik)
    {
        $this->icerik = $icerik;

        return $this;
    }

    /**
     * Get icerik
     *
     * @return string
     */
    public function getIcerik()
    {
        return $this->icerik;
    }

    /**
     * Set tur
     *
     * @param \Blob\Core\LibraryBundle\Entity\BildirimTur $tur
     *
     * @return BildirimSablon
     */
    public function setTur(\Blob\Core\LibraryBundle\Entity\BildirimTur $tur = null)
    {
        $this->tur = $tur;

        return $this;
    }

    /**
     * Get tur
     *
     * @return \Blob\Core\LibraryBundle\Entity\BildirimTur
     */
    public function getTur()
    {
        return $this->tur;
    }

    /**
     * Add bildirimler
     *
     * @param \Blob\Core\LibraryBundle\Entity\Bildirim $bildirimler
     *
     * @return BildirimSablon
     */
    public function addBildirimler(\Blob\Core\LibraryBundle\Entity\Bildirim $bildirimler)
    {
        $this->bildirimler[] = $bildirimler;

        return $this;
    }

    /**
     * Remove bildirimler
     *
     * @param \Blob\Core\LibraryBundle\Entity\Bildirim $bildirimler
     */
    public function removeBildirimler(\Blob\Core\LibraryBundle\Entity\Bildirim $bildirimler)
    {
        $this->bildirimler->removeElement($bildirimler);
    }

    /**
     * Get bildirimler
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getBildirimler()
    {
        return $this->bildirimler;
    }
}
