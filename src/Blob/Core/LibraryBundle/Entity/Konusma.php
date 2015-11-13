<?php

namespace Blob\Core\LibraryBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Konusma
 *
 * @ORM\Table(name="konusmalar")
 * @ORM\Entity
 */
class Konusma
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
     * @var array
     *
     * @ORM\Column(name="konusmacilar", type="json_array")
     */
    private $konusmacilar;

    /**
     * @ORM\OneToMany(targetEntity="KullaniciKonusma",mappedBy="konusma")
     */
    private $kullanici_konusmalari;


    /**
     * @ORM\OneToMany(targetEntity="Mesaj",mappedBy="konusma")
     */
    private $mesajlar;


    public function __construct()
    {
        $this->mesajlar = new ArrayCollection();
        $this->kullanici_konusmalari = new ArrayCollection();
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
     * Set konusmacilar
     *
     * @param array $konusmacilar
     *
     * @return Konusma
     */
    public function setKonusmacilar($konusmacilar)
    {
        $this->konusmacilar = $konusmacilar;

        return $this;
    }

    /**
     * Get konusmacilar
     *
     * @return array
     */
    public function getKonusmacilar()
    {
        return $this->konusmacilar;
    }

    /**
     * Add mesajlar
     *
     * @param \Blob\Core\LibraryBundle\Entity\Mesaj $mesajlar
     *
     * @return Konusma
     */
    public function addMesajlar(\Blob\Core\LibraryBundle\Entity\Mesaj $mesajlar)
    {
        $this->mesajlar[] = $mesajlar;

        return $this;
    }

    /**
     * Remove mesajlar
     *
     * @param \Blob\Core\LibraryBundle\Entity\Mesaj $mesajlar
     */
    public function removeMesajlar(\Blob\Core\LibraryBundle\Entity\Mesaj $mesajlar)
    {
        $this->mesajlar->removeElement($mesajlar);
    }

    /**
     * Get mesajlar
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMesajlar()
    {
        return $this->mesajlar;
    }

    /**
     * Add kullaniciKonusmalari
     *
     * @param \Blob\Core\LibraryBundle\Entity\KullaniciKonusma $kullaniciKonusmalari
     *
     * @return Konusma
     */
    public function addKullaniciKonusmalari(\Blob\Core\LibraryBundle\Entity\KullaniciKonusma $kullaniciKonusmalari)
    {
        $this->kullanici_konusmalari[] = $kullaniciKonusmalari;

        return $this;
    }

    /**
     * Remove kullaniciKonusmalari
     *
     * @param \Blob\Core\LibraryBundle\Entity\KullaniciKonusma $kullaniciKonusmalari
     */
    public function removeKullaniciKonusmalari(\Blob\Core\LibraryBundle\Entity\KullaniciKonusma $kullaniciKonusmalari)
    {
        $this->kullanici_konusmalari->removeElement($kullaniciKonusmalari);
    }

    /**
     * Get kullaniciKonusmalari
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getKullaniciKonusmalari()
    {
        return $this->kullanici_konusmalari;
    }
}
