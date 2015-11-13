<?php

namespace Blob\Core\LibraryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ayar
 *
 * @ORM\Table(name="ayarlar")
 * @ORM\Entity
 */
class Ayar
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
     * @var boolean
     *
     * @ORM\Column(name="profil_gizli", type="boolean",nullable=true)
     */
    private $profil_gizli;

    /**
     * @var boolean
     *
     * @ORM\Column(name="bildirimler", type="boolean",nullable=true)
     */
    private $bildirimler;

    /**
     * @ORM\OneToOne(targetEntity="Kullanici", inversedBy="ayar")
     * @ORM\JoinColumn(name="kullanici_id", referencedColumnName="id",onDelete="CASCADE")
     */
    protected $kullanici;


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
     * Set profilGizli
     *
     * @param boolean $profilGizli
     *
     * @return Ayar
     */
    public function setProfilGizli($profilGizli)
    {
        $this->profil_gizli = $profilGizli;

        return $this;
    }

    /**
     * Get profilGizli
     *
     * @return boolean
     */
    public function getProfilGizli()
    {
        return $this->profil_gizli;
    }

    /**
     * Set bildirimler
     *
     * @param boolean $bildirimler
     *
     * @return Ayar
     */
    public function setBildirimler($bildirimler)
    {
        $this->bildirimler = $bildirimler;

        return $this;
    }

    /**
     * Get bildirimler
     *
     * @return boolean
     */
    public function getBildirimler()
    {
        return $this->bildirimler;
    }

    /**
     * Set kullanici
     *
     * @param \Blob\Core\LibraryBundle\Entity\Kullanici $kullanici
     *
     * @return Ayar
     */
    public function setKullanici(\Blob\Core\LibraryBundle\Entity\Kullanici $kullanici = null)
    {
        $this->kullanici = $kullanici;

        return $this;
    }

    /**
     * Get kullanici
     *
     * @return \Blob\Core\LibraryBundle\Entity\Kullanici
     */
    public function getKullanici()
    {
        return $this->kullanici;
    }
}
