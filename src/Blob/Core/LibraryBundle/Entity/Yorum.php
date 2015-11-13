<?php

namespace Blob\Core\LibraryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Yorum
 *
 * @ORM\Table("yorumlar")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Yorum
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
     * @ORM\Column(name="yorum", type="string", length=140)
     */
    private $yorum;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime")
     */
    private $updatedAt;

    /**
     * @var integer
     *
     * @ORM\Column(name="durum", type="smallint")
     */
    private $durum;

    /**
     * @ORM\ManyToOne(targetEntity="Kullanici" , inversedBy="yorumlar")
     * @ORM\JoinColumn(name="kullanici_id" , referencedColumnName="id" , onDelete="CASCADE")
     */
    private $kullanici;

    /**
     * @ORM\ManyToOne(targetEntity="Fotograf" , inversedBy="yorumlar")
     * @ORM\JoinColumn(name="fotograf_id" , referencedColumnName="id" , onDelete="CASCADE")
     */
    private $fotograf;

    /**
     * Now we tell doctrine that before we persist or update we call the updatedTimestamps() function.
     *
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function updatedTimestamps()
    {
        $this->setUpdatedAt(new \DateTime(date('d-m-Y H:i')));

        if($this->getCreatedAt() == null)
        {
            $this->setCreatedAt(new \DateTime(date('d-m-Y H:i')));
        }
    }

    public function __toString()
    {
        return (string) $this->getYorum();
    }

    ## ## ## ## ## ## ## ## ## ## ## ## ## ## ## ## ## ## ## ##



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
     * Set yorum
     *
     * @param string $yorum
     *
     * @return Yorum
     */
    public function setYorum($yorum)
    {
        $this->yorum = $yorum;

        return $this;
    }

    /**
     * Get yorum
     *
     * @return string
     */
    public function getYorum()
    {
        return $this->yorum;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Yorum
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
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Yorum
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set durum
     *
     * @param integer $durum
     *
     * @return Yorum
     */
    public function setDurum($durum)
    {
        $this->durum = $durum;

        return $this;
    }

    /**
     * Get durum
     *
     * @return integer
     */
    public function getDurum()
    {
        return $this->durum;
    }

    /**
     * Set kullanici
     *
     * @param \Blob\Core\LibraryBundle\Entity\Kullanici $kullanici
     *
     * @return Yorum
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

    /**
     * Set fotograf
     *
     * @param \Blob\Core\LibraryBundle\Entity\Fotograf $fotograf
     *
     * @return Yorum
     */
    public function setFotograf(\Blob\Core\LibraryBundle\Entity\Fotograf $fotograf = null)
    {
        $this->fotograf = $fotograf;

        return $this;
    }

    /**
     * Get fotograf
     *
     * @return \Blob\Core\LibraryBundle\Entity\Fotograf
     */
    public function getFotograf()
    {
        return $this->fotograf;
    }
}
