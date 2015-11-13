<?php

namespace Blob\Core\LibraryBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * Fotograf
 *
 * @ORM\Table("fotograflar")
 * @ORM\Entity
 * @UniqueEntity(
 *    fields={"url", "hash", "icerik", "createdAt","updatedAt", "kullanici", "yorumlar", "begeniler"},
 *    errorPath="kullanici",
 *    message="Bu cep telefonu sistemde zaten kayıtlı."
 * )
 * @ORM\HasLifecycleCallbacks
 */
class Fotograf
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
     * @ORM\Column(name="url", type="text")
     */
    private $url;

    /**
     * @var string
     *
     * @ORM\Column(name="hash",length=50, unique=true)
     */
    private $hash;

    /**
     * @var string
     *
     * @ORM\Column(name="icerik", type="text")
     */
    private $icerik;

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
     * @ORM\ManyToOne(targetEntity="Kullanici" , inversedBy="fotograflar")
     * @ORM\JoinColumn(name="kullanici_id" , referencedColumnName="id" , onDelete="CASCADE")
     */
    private $kullanici;

    /**
     * @ORM\OneToMany(targetEntity="Begeni" , mappedBy="fotograf")
     */
    private $begeniler;

    /**
     * @ORM\OneToMany(targetEntity="Yorum" , mappedBy="fotograf")
     */
    private $yorumlar;

    /**
     * @ORM\OneToMany(targetEntity="Bildirim" , mappedBy="neyi")
     */
    private $bildirimler_neyin;


    public function __construct()
    {
        # Relationships

        $this->begeniler   = new ArrayCollection();
        $this->yorumlar    = new ArrayCollection();
        $this->bildirimler_neyin    = new ArrayCollection();
    }

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
     * Set url
     *
     * @param string $url
     *
     * @return Fotograf
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set hash
     *
     * @param string $hash
     *
     * @return Fotograf
     */
    public function setHash($hash)
    {
        $this->hash = $hash;

        return $this;
    }

    /**
     * Get hash
     *
     * @return string
     */
    public function getHash()
    {
        return $this->hash;
    }

    /**
     * Set icerik
     *
     * @param string $icerik
     *
     * @return Fotograf
     */
    public function setIcerik($icerik)
    {
        $this->icerik = $icerik;

        return $this;
    }

    /**
     * Get icerik
     *
     * @return string
     */
    public function getIcerik()
    {
        return $this->icerik;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Fotograf
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
     * @return Fotograf
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
     * @return Fotograf
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
     * Add begeniler
     *
     * @param \Blob\Core\LibraryBundle\Entity\Begeni $begeniler
     *
     * @return Fotograf
     */
    public function addBegeniler(\Blob\Core\LibraryBundle\Entity\Begeni $begeniler)
    {
        $this->begeniler[] = $begeniler;

        return $this;
    }

    /**
     * Remove begeniler
     *
     * @param \Blob\Core\LibraryBundle\Entity\Begeni $begeniler
     */
    public function removeBegeniler(\Blob\Core\LibraryBundle\Entity\Begeni $begeniler)
    {
        $this->begeniler->removeElement($begeniler);
    }

    /**
     * Get begeniler
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getBegeniler()
    {
        return $this->begeniler;
    }

    /**
     * Add yorumlar
     *
     * @param \Blob\Core\LibraryBundle\Entity\Yorum $yorumlar
     *
     * @return Fotograf
     */
    public function addYorumlar(\Blob\Core\LibraryBundle\Entity\Yorum $yorumlar)
    {
        $this->yorumlar[] = $yorumlar;

        return $this;
    }

    /**
     * Remove yorumlar
     *
     * @param \Blob\Core\LibraryBundle\Entity\Yorum $yorumlar
     */
    public function removeYorumlar(\Blob\Core\LibraryBundle\Entity\Yorum $yorumlar)
    {
        $this->yorumlar->removeElement($yorumlar);
    }

    /**
     * Get yorumlar
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getYorumlar()
    {
        return $this->yorumlar;
    }

    /**
     * Add bildirimlerNeyin
     *
     * @param \Blob\Core\LibraryBundle\Entity\Bildirim $bildirimlerNeyin
     *
     * @return Fotograf
     */
    public function addBildirimlerNeyin(\Blob\Core\LibraryBundle\Entity\Bildirim $bildirimlerNeyin)
    {
        $this->bildirimler_neyin[] = $bildirimlerNeyin;

        return $this;
    }

    /**
     * Remove bildirimlerNeyin
     *
     * @param \Blob\Core\LibraryBundle\Entity\Bildirim $bildirimlerNeyin
     */
    public function removeBildirimlerNeyin(\Blob\Core\LibraryBundle\Entity\Bildirim $bildirimlerNeyin)
    {
        $this->bildirimler_neyin->removeElement($bildirimlerNeyin);
    }

    /**
     * Get bildirimlerNeyin
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getBildirimlerNeyin()
    {
        return $this->bildirimler_neyin;
    }
}
