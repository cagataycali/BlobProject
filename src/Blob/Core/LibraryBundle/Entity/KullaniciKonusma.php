<?php

namespace Blob\Core\LibraryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * KullaniciKonusma
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class KullaniciKonusma
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
     * @ORM\ManyToOne(targetEntity="Konusma",inversedBy="kullanici_konusmalari")
     * @ORM\JoinColumn(name="konusma_id",referencedColumnName="id",onDelete="CASCADE")
     */
    private $konusma;

    /**
     * @ORM\ManyToOne(targetEntity="Kullanici",inversedBy="kullanici_konusmalari")
     * @ORM\JoinColumn(name="kullanici_id",referencedColumnName="id",onDelete="CASCADE")
     */
    private $kullanici;


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
     * Set konusma
     *
     * @param \Blob\Core\LibraryBundle\Entity\Konusma $konusma
     *
     * @return KullaniciKonusma
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
     * Set kullanici
     *
     * @param \Blob\Core\LibraryBundle\Entity\Kullanici $kullanici
     *
     * @return KullaniciKonusma
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
