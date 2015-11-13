<?php

namespace Blob\Core\LibraryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * KullaniciMesajGorulme
 *
 * @ORM\Table(name="kullanici_mesaj_gorulmeleri")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class KullaniciMesajGorulme
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
     * @ORM\ManyToOne(targetEntity="Mesaj",inversedBy="kullanici_mesaj_gorulmeleri")
     * @ORM\JoinColumn(name="mesaj_id",referencedColumnName="id",onDelete="CASCADE")
     */
    private $mesaj;

    /**
     * @ORM\ManyToOne(targetEntity="Kullanici",inversedBy="kullanici_mesaj_gorulmeleri")
     * @ORM\JoinColumn(name="kullanici_id",referencedColumnName="id",onDelete="CASCADE")
     */
    private $kullanici;

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

    ####################################

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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return KullaniciMesajGorulme
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
     * @return KullaniciMesajGorulme
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
     * Set mesaj
     *
     * @param \Blob\Core\LibraryBundle\Entity\Mesaj $mesaj
     *
     * @return KullaniciMesajGorulme
     */
    public function setMesaj(\Blob\Core\LibraryBundle\Entity\Mesaj $mesaj = null)
    {
        $this->mesaj = $mesaj;

        return $this;
    }

    /**
     * Get mesaj
     *
     * @return \Blob\Core\LibraryBundle\Entity\Mesaj
     */
    public function getMesaj()
    {
        return $this->mesaj;
    }

    /**
     * Set kullanici
     *
     * @param \Blob\Core\LibraryBundle\Entity\Kullanici $kullanici
     *
     * @return KullaniciMesajGorulme
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
