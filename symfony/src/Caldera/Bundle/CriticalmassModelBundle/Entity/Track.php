<?php

namespace Caldera\Bundle\CriticalmassModelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Table(name="track")
 * @ORM\Entity(repositoryClass="Caldera\Bundle\CriticalmassModelBundle\Repository\TrackRepository")
 * @Vich\Uploadable
 */
class Track
{
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $username;

    /**
     * @ORM\ManyToOne(targetEntity="Caldera\Bundle\CriticalmassModelBundle\Entity\Ride", inversedBy="tracks")
     * @ORM\JoinColumn(name="ride_id", referencedColumnName="id")
     */
    protected $ride;

    /**
     * @ORM\ManyToOne(targetEntity="Application\Sonata\UserBundle\Entity\User", inversedBy="tracks")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;

    /**
     * @ORM\ManyToOne(targetEntity="Caldera\Bundle\CriticalmassModelBundle\Entity\Ticket", inversedBy="tracks")
     * @ORM\JoinColumn(name="ticket_id", referencedColumnName="id")
     */
    protected $ticket;

    /**
     * @ORM\OneToOne(targetEntity="Caldera\Bundle\CriticalmassModelBundle\Entity\RideEstimate", mappedBy="track", cascade={"all"}, orphanRemoval=true)
     */
    protected $rideEstimate;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $creationDateTime;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $startDateTime;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $endDateTime;

    /**
     * @ORM\Column(type="float")
     */
    protected $distance;

    /**
     * @ORM\Column(type="integer")
     */
    protected $points;

    /**
     * @ORM\Column(type="integer")
     */
    protected $startPoint;

    /**
     * @ORM\Column(type="integer")
     */
    protected $endPoint;

    /**
     * @ORM\Column(type="string", length=32)
     */
    protected $md5Hash;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $activated = true;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $latLngList;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="track_file", fileNameProperty="trackFilename")
     * @var File
     */
    protected $trackFile;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @var string
     */
    protected $trackFilename;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var \DateTime
     */
    protected $updatedAt;

    public function __construct()
    {
        $this->setCreationDateTime(new \DateTime());

    }

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
     * Set username
     *
     * @param string $username
     * @return Track
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string 
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set ride
     *
     * @param Ride $ride
     * @return Track
     */
    public function setRide(Ride $ride = null)
    {
        $this->ride = $ride;

        return $this;
    }

    /**
     * Get ride
     *
     * @return Ride
     */
    public function getRide()
    {
        return $this->ride;
    }

    /**
     * Set user
     *
     * @param \Application\Sonata\UserBundle\Entity\User $user
     * @return Track
     */
    public function setUser(\Application\Sonata\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Application\Sonata\UserBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set ticket
     *
     * @param Ticket $ticket
     * @return Track
     */
    public function setTicket(Ticket $ticket = null)
    {
        $this->ticket = $ticket;

        return $this;
    }

    /**
     * Get ticket
     *
     * @return Ticket
     */
    public function getTicket()
    {
        return $this->ticket;
    }

    /**
     * Set creationDateTime
     *
     * @param \DateTime $creationDateTime
     * @return Track
     */
    public function setCreationDateTime($creationDateTime)
    {
        $this->creationDateTime = $creationDateTime;

        return $this;
    }

    /**
     * Get creationDateTime
     *
     * @return \DateTime 
     */
    public function getCreationDateTime()
    {
        return $this->creationDateTime;
    }

    /**
     * Set md5Hash
     *
     * @param string $md5Hash
     * @return Track
     */
    public function setMd5Hash($md5Hash)
    {
        $this->md5Hash = $md5Hash;

        return $this;
    }

    /**
     * Get md5Hash
     *
     * @return string 
     */
    public function getMd5Hash()
    {
        return $this->md5Hash;
    }

    /**
     * Set startDateTime
     *
     * @param \DateTime $startDateTime
     * @return Track
     */
    public function setStartDateTime($startDateTime)
    {
        $this->startDateTime = $startDateTime;

        return $this;
    }

    /**
     * Get startDateTime
     *
     * @return \DateTime 
     */
    public function getStartDateTime()
    {
        return $this->startDateTime->setTimezone(new \DateTimeZone('GMT'));
    }

    /**
     * Set endDateTime
     *
     * @param \DateTime $endDateTime
     * @return Track
     */
    public function setEndDateTime($endDateTime)
    {
        $this->endDateTime = $endDateTime;

        return $this;
    }

    /**
     * Get endDateTime
     *
     * @return \DateTime 
     */
    public function getEndDateTime()
    {
        return $this->endDateTime->setTimezone(new \DateTimeZone('GMT'));
    }

    /**
     * Set distance
     *
     * @param float $distance
     * @return Track
     */
    public function setDistance($distance)
    {
        $this->distance = $distance;

        return $this;
    }

    /**
     * Get distance
     *
     * @return float 
     */
    public function getDistance()
    {
        return $this->distance;
    }

    /**
     * Set points
     *
     * @param integer $points
     * @return Track
     */
    public function setPoints($points)
    {
        $this->points = $points;

        return $this;
    }

    /**
     * Get points
     *
     * @return integer 
     */
    public function getPoints()
    {
        return $this->points;
    }
    
    /**
     * @return mixed
     */
    public function getActivated()
    {
        return $this->activated;
    }

    /**
     * @param mixed $activated
     */
    public function setActivated($activated)
    {
        $this->activated = $activated;
    }
    
    /**
     * Set rideEstimate
     *
     * @param RideEstimate $rideEstimate
     * @return Track
     */
    public function setRideEstimate(RideEstimate $rideEstimate = null)
    {
        $this->rideEstimate = $rideEstimate;

        return $this;
    }

    /**
     * Get rideEstimate
     *
     * @return RideEstimate
     */
    public function getRideEstimate()
    {
        return $this->rideEstimate;
    }

    /**
     * Set latLngList
     *
     * @param string $latLngList
     * @return Track
     */
    public function setLatLngList($latLngList)
    {
        $this->latLngList = $latLngList;

        return $this;
    }

    /**
     * Get latLngList
     *
     * @return boolean 
     */
    public function getLatLngList()
    {
        return $this->latLngList;
    }

    public function getColorRed()
    {
        return ($this->getUser() != null ? $this->getUser()->getColorRed() : $this->getTicket()->getColorRed());
    }

    public function getColorGreen()
    {
        return ($this->getUser() != null ? $this->getUser()->getColorGreen() : $this->getTicket()->getColorGreen());
    }

    public function getColorBlue()
    {
        return ($this->getUser() != null ? $this->getUser()->getColorBlue() : $this->getTicket()->getColorBlue());
    }

    public function __toString()
    {
        $result = $this->getUsername().'(';

        if ($this->getCreationDateTime()) {
            $result .= $this->getCreationDateTime()->format('Y-m-d');
        }

        if ($this->getRide()) {
            $result .= ', '.$this->getRide()->getCity()->getCity();
        }

        $result .= ')';

        return $result;
    }
    
    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the  update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $track
     */
    public function setTrackFile(File $track = null)
    {
        $this->trackFile = $track;

        if ($track) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTime('now');
        }
    }

    /**
     * @return File
     */
    public function getTrackFile()
    {
        return $this->trackFile;
    }

    /**
     * @param string $trackFilename
     */
    public function setTrackFilename($trackFilename)
    {
        $this->trackFilename = $trackFilename;
    }

    /**
     * @return string
     */
    public function getTrackFilename()
    {
        return $this->trackFilename;
    }

    /**
     * Set startPoint
     *
     * @param integer $startPoint
     * @return Track
     */
    public function setStartPoint($startPoint)
    {
        if ($startPoint >= 1) {
            $this->startPoint = $startPoint;
        } else {
            $this->startPoint = 1;
        }

        return $this;
    }

    /**
     * Get startPoint
     *
     * @return integer 
     */
    public function getStartPoint()
    {
        return $this->startPoint;
    }

    /**
     * Set endPoint
     *
     * @param integer $endPoint
     * @return Track
     */
    public function setEndPoint($endPoint)
    {
        if ($endPoint <= $this->points) {
            $this->endPoint = $endPoint;
        } else {
            $this->endPoint = $this->points - 1;
        }

        return $this;
    }

    /**
     * Get endPoint
     *
     * @return integer 
     */
    public function getEndPoint()
    {
        return $this->endPoint;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return Track
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
    
    public function getDurationInterval()
    {
        return $this->getEndDateTime()->diff($this->getStartDateTime());
    }
    
    public function getDurationInSeconds()
    {
        return $this->getEndDateTime()->getTimestamp() - $this->getStartDateTime()->getTimestamp();
    }
    
    public function getAverageVelocity()
    {
        $kilometres = $this->getDistance();
        $seconds = $this->getEndDateTime()->getTimestamp() - $this->getStartDateTime()->getTimestamp();
        
        $hours = (float) $seconds / 3600;
        $velocity = $kilometres / $hours;
        
        return $velocity;
    }
}
