<?php

namespace Blob\Core\LibraryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Begeni
 *
 * @ORM\Table("begeniler")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Begeni
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
     * @ORM\ManyToOne(targetEntity="Kullanici" , inversedBy="begeniler")
     * @ORM\JoinColumn(name="kullanici_id" , referencedColumnName="id" , onDelete="CASCADE")
     */
    private $kullanici;

    /**
     * @ORM\ManyToOne(targetEntity="Fotograf" , inversedBy="begeniler")
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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Begeni
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
     * @return Begeni
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
     * Set kullanici
     *
     * @param \Blob\Core\LibraryBundle\Entity\Kullanici $kullanici
     *
     * @return Begeni
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
     * @return Begeni
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
