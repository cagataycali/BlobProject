<?php

namespace Blob\Core\LibraryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Cep
 *
 * @ORM\Table(name="kullanici_cep")
 * @ORM\Entity
 * @UniqueEntity(
 *    fields={"cep", "kullanici"},
 *    errorPath="kullanici",
 *    message="Bu cep telefonu sistemde zaten kayıtlı."
 * )
 */
class Cep
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
     * @ORM\Column(name="cep", length=35, unique=true)
     */
    private $cep;

    /**
     * @ORM\OneToOne(targetEntity="Kullanici", inversedBy="cep")
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
     * Set cep
     *
     * @param string $cep
     *
     * @return Cep
     */
    public function setCep($cep)
    {
        $this->cep = $cep;

        return $this;
    }

    /**
     * Get cep
     *
     * @return string
     */
    public function getCep()
    {
        return $this->cep;
    }

    /**
     * Set kullanici
     *
     * @param \Blob\Core\LibraryBundle\Entity\Kullanici $kullanici
     *
     * @return Cep
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
