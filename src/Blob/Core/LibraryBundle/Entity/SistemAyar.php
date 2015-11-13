<?php

namespace Blob\Core\LibraryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SistemAyar
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class SistemAyar
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
     * @var integer
     *
     * @ORM\Column(name="ana_sayfadaki_fotograf_sayisi", type="integer")
     */
    private $anaSayfadakiFotografSayisi;

    /**
     * @var integer
     *
     * @ORM\Column(name="kaydirinca_gelecek_fotograf_sayisi", type="integer")
     */
    private $kaydirincaGelecekFotografSayisi;

    /**
     * @var string
     *
     * @ORM\Column(name="tema_renk", type="string", length=255)
     */
    private $temaRenk;


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
     * Set anaSayfadakiFotografSayisi
     *
     * @param integer $anaSayfadakiFotografSayisi
     *
     * @return SistemAyar
     */
    public function setAnaSayfadakiFotografSayisi($anaSayfadakiFotografSayisi)
    {
        $this->anaSayfadakiFotografSayisi = $anaSayfadakiFotografSayisi;

        return $this;
    }

    /**
     * Get anaSayfadakiFotografSayisi
     *
     * @return integer
     */
    public function getAnaSayfadakiFotografSayisi()
    {
        return $this->anaSayfadakiFotografSayisi;
    }

    /**
     * Set kaydirincaGelecekFotografSayisi
     *
     * @param integer $kaydirincaGelecekFotografSayisi
     *
     * @return SistemAyar
     */
    public function setKaydirincaGelecekFotografSayisi($kaydirincaGelecekFotografSayisi)
    {
        $this->kaydirincaGelecekFotografSayisi = $kaydirincaGelecekFotografSayisi;

        return $this;
    }

    /**
     * Get kaydirincaGelecekFotografSayisi
     *
     * @return integer
     */
    public function getKaydirincaGelecekFotografSayisi()
    {
        return $this->kaydirincaGelecekFotografSayisi;
    }

    /**
     * Set temaRenk
     *
     * @param string $temaRenk
     *
     * @return SistemAyar
     */
    public function setTemaRenk($temaRenk)
    {
        $this->temaRenk = $temaRenk;

        return $this;
    }

    /**
     * Get temaRenk
     *
     * @return string
     */
    public function getTemaRenk()
    {
        return $this->temaRenk;
    }
}
