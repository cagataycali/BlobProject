<?php

namespace Blob\Core\LibraryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Profil
 *
 * @ORM\Table(name="profil")
 * @ORM\Entity
 */
class Profil
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
     * @ORM\Column(name="aciklama", type="string", length=255,nullable=true )
     */
    private $aciklama;

    /**
     * @var string
     *
     * @ORM\Column(name="web_adresi", type="string", length=255,nullable=true )
     */
    private $webAdresi;

    /**
     * @ORM\OneToOne(targetEntity="Kullanici", inversedBy="profil")
     * @ORM\JoinColumn(name="kullanici_id", referencedColumnName="id",onDelete="CASCADE")
     */
    protected $kullanici;

    # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #


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
     * Set aciklama
     *
     * @param string $aciklama
     *
     * @return Profil
     */
    public function setAciklama($aciklama)
    {
        $this->aciklama = $aciklama;

        return $this;
    }

    /**
     * Get aciklama
     *
     * @return string
     */
    public function getAciklama()
    {
        return $this->aciklama;
    }

    /**
     * Set webAdresi
     *
     * @param string $webAdresi
     *
     * @return Profil
     */
    public function setWebAdresi($webAdresi)
    {
        $this->webAdresi = $webAdresi;

        return $this;
    }

    /**
     * Get webAdresi
     *
     * @return string
     */
    public function getWebAdresi()
    {
        return $this->webAdresi;
    }

    /**
     * Set kullanici
     *
     * @param \Blob\Core\LibraryBundle\Entity\Kullanici $kullanici
     *
     * @return Profil
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
