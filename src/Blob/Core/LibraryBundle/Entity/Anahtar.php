<?php

namespace Blob\Core\LibraryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * Anahtar
 *
 * @ORM\Table(name="anahtarlar")
 * @ORM\Entity
 * @UniqueEntity(
 *    fields={"accessToken", "kullanici"},
 *    errorPath="accessToken",
 *    message="Bu kullanıcı başka yerde oturum açmış ."
 * )
 *
 */
class Anahtar
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
     * @ORM\Column(name="accessToken", length=255, unique=true)
     */
    private $accessToken;

    /**
     * @ORM\OneToOne(targetEntity="Kullanici", inversedBy="anahtar")
     * @ORM\JoinColumn(name="kullanici_id", referencedColumnName="id",onDelete="CASCADE")
     */
    protected $kullanici;

    /**
     * @var string
     *
     * @ORM\Column(name="os_type", type="string", length=255)
     */
    private $osType;

    /**
     * @var string
     *
     * @ORM\Column(name="os_version", type="string", length=255)
     */
    private $osVersion;

    /**
     * @var string
     *
     * @ORM\Column(name="device_model", type="string", length=255)
     */
    private $deviceModel;

    /**
     * @var string
     *
     * @ORM\Column(name="device_token", type="string", length=255)
     */
    private $deviceToken;

    /**
     * @var string
     *
     * @ORM\Column(name="register_id", type="string", length=255, nullable=true)
     */
    private $registerId;

    /**
     * @var string
     *
     * @ORM\Column(name="ip", type="string", length=255)
     */
    private $ip;


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
     * Set accessToken
     *
     * @param string $accessToken
     *
     * @return Anahtar
     */
    public function setAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;

        return $this;
    }

    /**
     * Get accessToken
     *
     * @return string
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }

    /**
     * Set osType
     *
     * @param string $osType
     *
     * @return Anahtar
     */
    public function setOsType($osType)
    {
        $this->osType = $osType;

        return $this;
    }

    /**
     * Get osType
     *
     * @return string
     */
    public function getOsType()
    {
        return $this->osType;
    }

    /**
     * Set osVersion
     *
     * @param string $osVersion
     *
     * @return Anahtar
     */
    public function setOsVersion($osVersion)
    {
        $this->osVersion = $osVersion;

        return $this;
    }

    /**
     * Get osVersion
     *
     * @return string
     */
    public function getOsVersion()
    {
        return $this->osVersion;
    }

    /**
     * Set deviceModel
     *
     * @param string $deviceModel
     *
     * @return Anahtar
     */
    public function setDeviceModel($deviceModel)
    {
        $this->deviceModel = $deviceModel;

        return $this;
    }

    /**
     * Get deviceModel
     *
     * @return string
     */
    public function getDeviceModel()
    {
        return $this->deviceModel;
    }

    /**
     * Set deviceToken
     *
     * @param string $deviceToken
     *
     * @return Anahtar
     */
    public function setDeviceToken($deviceToken)
    {
        $this->deviceToken = $deviceToken;

        return $this;
    }

    /**
     * Get deviceToken
     *
     * @return string
     */
    public function getDeviceToken()
    {
        return $this->deviceToken;
    }

    /**
     * Set registerId
     *
     * @param string $registerId
     *
     * @return Anahtar
     */
    public function setRegisterId($registerId)
    {
        $this->registerId = $registerId;

        return $this;
    }

    /**
     * Get registerId
     *
     * @return string
     */
    public function getRegisterId()
    {
        return $this->registerId;
    }

    /**
     * Set ip
     *
     * @param string $ip
     *
     * @return Anahtar
     */
    public function setIp($ip)
    {
        $this->ip = $ip;

        return $this;
    }

    /**
     * Get ip
     *
     * @return string
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * Set kullanici
     *
     * @param \Blob\Core\LibraryBundle\Entity\Kullanici $kullanici
     *
     * @return Anahtar
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
