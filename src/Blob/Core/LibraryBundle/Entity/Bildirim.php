<?php

namespace Blob\Core\LibraryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Bildirim
 *
 * @ORM\Table("bildirimler")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Bildirim
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
     * @ORM\Column(name="durum", type="boolean")
     */
    private $durum;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity="Kullanici" , inversedBy="bildirimler")
     * @ORM\JoinColumn(name="kullanici_id" , referencedColumnName="id" , onDelete="CASCADE")
     */
    private $kullanici;

    /**
     * @ORM\ManyToOne(targetEntity="BildirimSablon" , inversedBy="bildirimler")
     * @ORM\JoinColumn(name="sablon_id" , referencedColumnName="id" , onDelete="CASCADE")
     */
    private $sablon;

    /**
     *
     * @ORM\ManyToOne(targetEntity="Kullanici", inversedBy="bildirimler_kimden")
     * @ORM\JoinColumn(name="kim_id", referencedColumnName="id",onDelete="CASCADE")
     */
    protected $kim;

    /**
     *
     * @ORM\ManyToOne(targetEntity="Fotograf", inversedBy="bildirimler_neyin")
     * @ORM\JoinColumn(name="fotograf_id", referencedColumnName="id",onDelete="CASCADE")
     */
    protected $neyi;


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
     * @param boolean $durum
     *
     * @return Bildirim
     */
    public function setDurum($durum)
    {
        $this->durum = $durum;

        return $this;
    }

    /**
     * Get durum
     *
     * @return boolean
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
     * @return Bildirim
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
     * Set kullanici
     *
     * @param \Blob\Core\LibraryBundle\Entity\Kullanici $kullanici
     *
     * @return Bildirim
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
     * Set sablon
     *
     * @param \Blob\Core\LibraryBundle\Entity\BildirimSablon $sablon
     *
     * @return Bildirim
     */
    public function setSablon(\Blob\Core\LibraryBundle\Entity\BildirimSablon $sablon = null)
    {
        $this->sablon = $sablon;

        return $this;
    }

    /**
     * Get sablon
     *
     * @return \Blob\Core\LibraryBundle\Entity\BildirimSablon
     */
    public function getSablon()
    {
        return $this->sablon;
    }

    /**
     * Set kim
     *
     * @param \Blob\Core\LibraryBundle\Entity\Kullanici $kim
     *
     * @return Bildirim
     */
    public function setKim(\Blob\Core\LibraryBundle\Entity\Kullanici $kim = null)
    {
        $this->kim = $kim;

        return $this;
    }

    /**
     * Get kim
     *
     * @return \Blob\Core\LibraryBundle\Entity\Kullanici
     */
    public function getKim()
    {
        return $this->kim;
    }

    /**
     * Set neyi
     *
     * @param \Blob\Core\LibraryBundle\Entity\Fotograf $neyi
     *
     * @return Bildirim
     */
    public function setNeyi(\Blob\Core\LibraryBundle\Entity\Fotograf $neyi = null)
    {
        $this->neyi = $neyi;

        return $this;
    }

    /**
     * Get neyi
     *
     * @return \Blob\Core\LibraryBundle\Entity\Fotograf
     */
    public function getNeyi()
    {
        return $this->neyi;
    }
}
