<?php

namespace Blob\Core\LibraryBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Mesaj
 *
 * @ORM\Table(name="mesajlar")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Mesaj
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
     * @ORM\Column(name="mesaj", type="text")
     */
    private $mesaj;

    /**
     * @var array
     *
     * @ORM\Column(name="silenler", type="json_array",nullable=true)
     */
    private $silenler;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity="Konusma",inversedBy="mesajlar")
     * @ORM\JoinColumn(name="konusma_id",referencedColumnName="id",onDelete="CASCADE")
     */
    private $konusma;

    /**
     * @ORM\ManyToOne(targetEntity="Kullanici",inversedBy="mesajlar")
     * @ORM\JoinColumn(referencedColumnName="id",onDelete="CASCADE",name="yazan_id")
     */
    private $yazan;

    /**
     * @ORM\OneToMany(targetEntity="KullaniciMesajGorulme",mappedBy="mesaj")
     */
    private $kullanici_mesaj_gorulmeleri;


    /**
     * Now we tell doctrine that before we persist or update we call the updatedTimestamps() function.
     *
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function updatedTimestamps()
    {

        if($this->getCreatedAt() == null)
        {
            $this->setCreatedAt(new \DateTime(date('d-m-Y H:i')));
        }
    }

    public function __toString()
    {
        return (string) $this->getMesaj();
    }

    public function __construct()
    {
        $this->kullanici_mesaj_gorulmeleri = new ArrayCollection();
    }

    ####################################################

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
     * Set mesaj
     *
     * @param string $mesaj
     *
     * @return Mesaj
     */
    public function setMesaj($mesaj)
    {
        $this->mesaj = $mesaj;

        return $this;
    }

    /**
     * Get mesaj
     *
     * @return string
     */
    public function getMesaj()
    {
        return $this->mesaj;
    }

    /**
     * Set silenler
     *
     * @param array $silenler
     *
     * @return Mesaj
     */
    public function setSilenler($silenler)
    {
        $this->silenler = $silenler;

        return $this;
    }

    /**
     * Get silenler
     *
     * @return array
     */
    public function getSilenler()
    {
        return $this->silenler;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Mesaj
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set konusma
     *
     * @param \Blob\Core\LibraryBundle\Entity\Konusma $konusma
     *
     * @return Mesaj
     */
    public function setKonusma(\Blob\Core\LibraryBundle\Entity\Konusma $konusma = null)
    {
        $this->konusma = $konusma;

        return $this;
    }

    /**
     * Get konusma
     *
     * @return \Blob\Core\LibraryBundle\Entity\Konusma
     */
    public function getKonusma()
    {
        return $this->konusma;
    }

    /**
     * Set yazan
     *
     * @param \Blob\Core\LibraryBundle\Entity\Kullanici $yazan
     *
     * @return Mesaj
     */
    public function setYazan(\Blob\Core\LibraryBundle\Entity\Kullanici $yazan = null)
    {
        $this->yazan = $yazan;

        return $this;
    }

    /**
     * Get yazan
     *
     * @return \Blob\Core\LibraryBundle\Entity\Kullanici
     */
    public function getYazan()
    {
        return $this->yazan;
    }

    /**
     * Add kullaniciMesajGorulmeleri
     *
     * @param \Blob\Core\LibraryBundle\Entity\KullaniciMesajGorulme $kullaniciMesajGorulmeleri
     *
     * @return Mesaj
     */
    public function addKullaniciMesajGorulmeleri(\Blob\Core\LibraryBundle\Entity\KullaniciMesajGorulme $kullaniciMesajGorulmeleri)
    {
        $this->kullanici_mesaj_gorulmeleri[] = $kullaniciMesajGorulmeleri;

        return $this;
    }

    /**
     * Remove kullaniciMesajGorulmeleri
     *
     * @param \Blob\Core\LibraryBundle\Entity\KullaniciMesajGorulme $kullaniciMesajGorulmeleri
     */
    public function removeKullaniciMesajGorulmeleri(\Blob\Core\LibraryBundle\Entity\KullaniciMesajGorulme $kullaniciMesajGorulmeleri)
    {
        $this->kullanici_mesaj_gorulmeleri->removeElement($kullaniciMesajGorulmeleri);
    }

    /**
     * Get kullaniciMesajGorulmeleri
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getKullaniciMesajGorulmeleri()
    {
        return $this->kullanici_mesaj_gorulmeleri;
    }
}
