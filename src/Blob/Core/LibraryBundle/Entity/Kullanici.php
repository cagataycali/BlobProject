<?php
namespace Blob\Core\LibraryBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="kullanicilar")
 */
class Kullanici extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="Fotograf" , mappedBy="kullanici")
     */
    private $fotograflar;

    /**
     * @ORM\OneToMany(targetEntity="Begeni" , mappedBy="kullanici")
     */
    private $begeniler;

    /**
     * @ORM\OneToMany(targetEntity="Yorum" , mappedBy="kullanici")
     */
    private $yorumlar;

    /**
     * @ORM\OneToMany(targetEntity="Bildirim" , mappedBy="kullanici")
     */
    private $bildirimler;

    /**
     * @ORM\OneToMany(targetEntity="Takip" , mappedBy="takip_eden")
     */
    private $takip_eden;

    /**
     * @ORM\OneToMany(targetEntity="Takip" , mappedBy="takip_edilen")
     */
    private $takip_edilen;

    /**
     * @ORM\OneToOne(targetEntity="Profil", mappedBy="kullanici")
     */
    protected $profil;

    /**
     * @ORM\OneToOne(targetEntity="Ayar", mappedBy="kullanici")
     */
    protected $ayar;

    /**
     * @ORM\OneToOne(targetEntity="Cep", mappedBy="kullanici")
     */
    protected $cep;

    /**
     * @ORM\OneToOne(targetEntity="Anahtar", mappedBy="kullanici")
     */
    protected $anahtar;

    /**
     * @ORM\OneToMany(targetEntity="Bildirim", mappedBy="kim")
     */
    protected $bildirimler_kimden;

    /**
     * @ORM\OneToMany(targetEntity="Mesaj",mappedBy="yazan")
     */
    protected $mesajlar;

    /**
     * @ORM\OneToMany(targetEntity="KullaniciKonusma",mappedBy="kullanici")
     */
    protected $kullanici_konusmalari;

    /**
     * @ORM\OneToMany(targetEntity="KullaniciMesajGorulme",mappedBy="kullanici")
     */
    private $kullanici_mesaj_gorulmeleri;

    /**
     * Date/Time of the last activity
     *
     * @var \Datetime
     * @ORM\Column(name="last_activity_at", type="datetime",nullable=true)
     */
    protected $lastActivityAt;


    public function __construct()
    {
        parent::__construct();

        # Relationships

        $this->fotograflar = new ArrayCollection();
        $this->begeniler   = new ArrayCollection();
        $this->yorumlar    = new ArrayCollection();
        $this->bildirimler = new ArrayCollection();
        $this->takip_eden = new ArrayCollection();
        $this->takip_edilen = new ArrayCollection();
        $this->bildirimler_kimden = new ArrayCollection();
        $this->mesajlar = new ArrayCollection();
        $this->kullanici_mesaj_gorulmeleri = new ArrayCollection();
        $this->kullanici_konusmalari = new ArrayCollection();
    }

    /**
     * @return Bool Whether the user is active or not
     */
    public function isActiveNow()
    {
        // Delay during wich the user will be considered as still active
        $delay = new \DateTime('10 seconds ago');

        return ( $this->getLastActivityAt() > $delay );
    }

    public function __toString()
    {
        return (string) $this->getUsername();
    }

    # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #



    /**
     * Set lastActivityAt
     *
     * @param \DateTime $lastActivityAt
     *
     * @return Kullanici
     */
    public function setLastActivityAt($lastActivityAt)
    {
        $this->lastActivityAt = $lastActivityAt;

        return $this;
    }

    /**
     * Get lastActivityAt
     *
     * @return \DateTime
     */
    public function getLastActivityAt()
    {
        return $this->lastActivityAt;
    }

    /**
     * Add fotograflar
     *
     * @param \Blob\Core\LibraryBundle\Entity\Fotograf $fotograflar
     *
     * @return Kullanici
     */
    public function addFotograflar(\Blob\Core\LibraryBundle\Entity\Fotograf $fotograflar)
    {
        $this->fotograflar[] = $fotograflar;

        return $this;
    }

    /**
     * Remove fotograflar
     *
     * @param \Blob\Core\LibraryBundle\Entity\Fotograf $fotograflar
     */
    public function removeFotograflar(\Blob\Core\LibraryBundle\Entity\Fotograf $fotograflar)
    {
        $this->fotograflar->removeElement($fotograflar);
    }

    /**
     * Get fotograflar
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFotograflar()
    {
        return $this->fotograflar;
    }

    /**
     * Add begeniler
     *
     * @param \Blob\Core\LibraryBundle\Entity\Begeni $begeniler
     *
     * @return Kullanici
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
     * @return Kullanici
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
     * Add bildirimler
     *
     * @param \Blob\Core\LibraryBundle\Entity\Bildirim $bildirimler
     *
     * @return Kullanici
     */
    public function addBildirimler(\Blob\Core\LibraryBundle\Entity\Bildirim $bildirimler)
    {
        $this->bildirimler[] = $bildirimler;

        return $this;
    }

    /**
     * Remove bildirimler
     *
     * @param \Blob\Core\LibraryBundle\Entity\Bildirim $bildirimler
     */
    public function removeBildirimler(\Blob\Core\LibraryBundle\Entity\Bildirim $bildirimler)
    {
        $this->bildirimler->removeElement($bildirimler);
    }

    /**
     * Get bildirimler
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getBildirimler()
    {
        return $this->bildirimler;
    }

    /**
     * Add takipEden
     *
     * @param \Blob\Core\LibraryBundle\Entity\Takip $takipEden
     *
     * @return Kullanici
     */
    public function addTakipEden(\Blob\Core\LibraryBundle\Entity\Takip $takipEden)
    {
        $this->takip_eden[] = $takipEden;

        return $this;
    }

    /**
     * Remove takipEden
     *
     * @param \Blob\Core\LibraryBundle\Entity\Takip $takipEden
     */
    public function removeTakipEden(\Blob\Core\LibraryBundle\Entity\Takip $takipEden)
    {
        $this->takip_eden->removeElement($takipEden);
    }

    /**
     * Get takipEden
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTakipEden()
    {
        return $this->takip_eden;
    }

    /**
     * Add takipEdilen
     *
     * @param \Blob\Core\LibraryBundle\Entity\Takip $takipEdilen
     *
     * @return Kullanici
     */
    public function addTakipEdilen(\Blob\Core\LibraryBundle\Entity\Takip $takipEdilen)
    {
        $this->takip_edilen[] = $takipEdilen;

        return $this;
    }

    /**
     * Remove takipEdilen
     *
     * @param \Blob\Core\LibraryBundle\Entity\Takip $takipEdilen
     */
    public function removeTakipEdilen(\Blob\Core\LibraryBundle\Entity\Takip $takipEdilen)
    {
        $this->takip_edilen->removeElement($takipEdilen);
    }

    /**
     * Get takipEdilen
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTakipEdilen()
    {
        return $this->takip_edilen;
    }

    /**
     * Set profil
     *
     * @param \Blob\Core\LibraryBundle\Entity\Profil $profil
     *
     * @return Kullanici
     */
    public function setProfil(\Blob\Core\LibraryBundle\Entity\Profil $profil = null)
    {
        $this->profil = $profil;

        return $this;
    }

    /**
     * Get profil
     *
     * @return \Blob\Core\LibraryBundle\Entity\Profil
     */
    public function getProfil()
    {
        return $this->profil;
    }

    /**
     * Set ayar
     *
     * @param \Blob\Core\LibraryBundle\Entity\Ayar $ayar
     *
     * @return Kullanici
     */
    public function setAyar(\Blob\Core\LibraryBundle\Entity\Ayar $ayar = null)
    {
        $this->ayar = $ayar;

        return $this;
    }

    /**
     * Get ayar
     *
     * @return \Blob\Core\LibraryBundle\Entity\Ayar
     */
    public function getAyar()
    {
        return $this->ayar;
    }

    /**
     * Set cep
     *
     * @param \Blob\Core\LibraryBundle\Entity\Cep $cep
     *
     * @return Kullanici
     */
    public function setCep(\Blob\Core\LibraryBundle\Entity\Cep $cep = null)
    {
        $this->cep = $cep;

        return $this;
    }

    /**
     * Get cep
     *
     * @return \Blob\Core\LibraryBundle\Entity\Cep
     */
    public function getCep()
    {
        return $this->cep;
    }

    /**
     * Set anahtar
     *
     * @param \Blob\Core\LibraryBundle\Entity\Anahtar $anahtar
     *
     * @return Kullanici
     */
    public function setAnahtar(\Blob\Core\LibraryBundle\Entity\Anahtar $anahtar = null)
    {
        $this->anahtar = $anahtar;

        return $this;
    }

    /**
     * Get anahtar
     *
     * @return \Blob\Core\LibraryBundle\Entity\Anahtar
     */
    public function getAnahtar()
    {
        return $this->anahtar;
    }

    /**
     * Add bildirimlerKimden
     *
     * @param \Blob\Core\LibraryBundle\Entity\Bildirim $bildirimlerKimden
     *
     * @return Kullanici
     */
    public function addBildirimlerKimden(\Blob\Core\LibraryBundle\Entity\Bildirim $bildirimlerKimden)
    {
        $this->bildirimler_kimden[] = $bildirimlerKimden;

        return $this;
    }

    /**
     * Remove bildirimlerKimden
     *
     * @param \Blob\Core\LibraryBundle\Entity\Bildirim $bildirimlerKimden
     */
    public function removeBildirimlerKimden(\Blob\Core\LibraryBundle\Entity\Bildirim $bildirimlerKimden)
    {
        $this->bildirimler_kimden->removeElement($bildirimlerKimden);
    }

    /**
     * Get bildirimlerKimden
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getBildirimlerKimden()
    {
        return $this->bildirimler_kimden;
    }

    /**
     * Add mesajlar
     *
     * @param \Blob\Core\LibraryBundle\Entity\Mesaj $mesajlar
     *
     * @return Kullanici
     */
    public function addMesajlar(\Blob\Core\LibraryBundle\Entity\Mesaj $mesajlar)
    {
        $this->mesajlar[] = $mesajlar;

        return $this;
    }

    /**
     * Remove mesajlar
     *
     * @param \Blob\Core\LibraryBundle\Entity\Mesaj $mesajlar
     */
    public function removeMesajlar(\Blob\Core\LibraryBundle\Entity\Mesaj $mesajlar)
    {
        $this->mesajlar->removeElement($mesajlar);
    }

    /**
     * Get mesajlar
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMesajlar()
    {
        return $this->mesajlar;
    }

    /**
     * Add kullaniciKonusmalari
     *
     * @param \Blob\Core\LibraryBundle\Entity\KullaniciKonusma $kullaniciKonusmalari
     *
     * @return Kullanici
     */
    public function addKullaniciKonusmalari(\Blob\Core\LibraryBundle\Entity\KullaniciKonusma $kullaniciKonusmalari)
    {
        $this->kullanici_konusmalari[] = $kullaniciKonusmalari;

        return $this;
    }

    /**
     * Remove kullaniciKonusmalari
     *
     * @param \Blob\Core\LibraryBundle\Entity\KullaniciKonusma $kullaniciKonusmalari
     */
    public function removeKullaniciKonusmalari(\Blob\Core\LibraryBundle\Entity\KullaniciKonusma $kullaniciKonusmalari)
    {
        $this->kullanici_konusmalari->removeElement($kullaniciKonusmalari);
    }

    /**
     * Get kullaniciKonusmalari
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getKullaniciKonusmalari()
    {
        return $this->kullanici_konusmalari;
    }

    /**
     * Add kullaniciMesajGorulmeleri
     *
     * @param \Blob\Core\LibraryBundle\Entity\KullaniciMesajGorulme $kullaniciMesajGorulmeleri
     *
     * @return Kullanici
     */
    public function addKullaniciMesajGorulmeleri(\Blob\Core\LibraryBundle\Entity\KullaniciMesajGorulme $kullaniciMesajGorulmeleri)
    {
        $this->kullanici_mesaj_gorulmeleri[] = $kullaniciMesajGorulmeleri;

        return $this;
    }

    /**
     * Remove kullaniciMesajGorulmeleri
     *
     * @param \Blob\Core\LibraryBundle\Entity\KullaniciMesajGorulme $kullaniciMesajGorulmeleri
     */
    public function removeKullaniciMesajGorulmeleri(\Blob\Core\LibraryBundle\Entity\KullaniciMesajGorulme $kullaniciMesajGorulmeleri)
    {
        $this->kullanici_mesaj_gorulmeleri->removeElement($kullaniciMesajGorulmeleri);
    }

    /**
     * Get kullaniciMesajGorulmeleri
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getKullaniciMesajGorulmeleri()
    {
        return $this->kullanici_mesaj_gorulmeleri;
    }
}
