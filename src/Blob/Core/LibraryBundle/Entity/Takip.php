<?php

namespace Blob\Core\LibraryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Takip
 *
 * @ORM\Table("takipler")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Takip
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
     * @ORM\Column(name="durum", type="smallint")
     */
    private $durum;


    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity="Kullanici" , inversedBy="takip_eden")
     * @ORM\JoinColumn(name="takip_eden_id" , referencedColumnName="id" , onDelete="CASCADE")
     */
    private $takip_eden;

    /**
     * @ORM\ManyToOne(targetEntity="Kullanici" , inversedBy="takip_edilen")
     * @ORM\JoinColumn(name="takip_edilen" , referencedColumnName="id" , onDelete="CASCADE")
     */
    private $takip_edilen;

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
     * Set durum
     *
     * @param integer $durum
     *
     * @return Takip
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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Takip
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
     * Set takipEden
     *
     * @param \Blob\Core\LibraryBundle\Entity\Kullanici $takipEden
     *
     * @return Takip
     */
    public function setTakipEden(\Blob\Core\LibraryBundle\Entity\Kullanici $takipEden = null)
    {
        $this->takip_eden = $takipEden;

        return $this;
    }

    /**
     * Get takipEden
     *
     * @return \Blob\Core\LibraryBundle\Entity\Kullanici
     */
    public function getTakipEden()
    {
        return $this->takip_eden;
    }

    /**
     * Set takipEdilen
     *
     * @param \Blob\Core\LibraryBundle\Entity\Kullanici $takipEdilen
     *
     * @return Takip
     */
    public function setTakipEdilen(\Blob\Core\LibraryBundle\Entity\Kullanici $takipEdilen = null)
    {
        $this->takip_edilen = $takipEdilen;

        return $this;
    }

    /**
     * Get takipEdilen
     *
     * @return \Blob\Core\LibraryBundle\Entity\Kullanici
     */
    public function getTakipEdilen()
    {
        return $this->takip_edilen;
    }

    /**
     * Set bildirimler
     *
     * @param \Blob\Core\LibraryBundle\Entity\Bildirim $bildirimler
     *
     * @return Takip
     */
    public function setBildirimler(\Blob\Core\LibraryBundle\Entity\Bildirim $bildirimler = null)
    {
        $this->bildirimler = $bildirimler;

        return $this;
    }

    /**
     * Get bildirimler
     *
     * @return \Blob\Core\LibraryBundle\Entity\Bildirim
     */
    public function getBildirimler()
    {
        return $this->bildirimler;
    }
}
