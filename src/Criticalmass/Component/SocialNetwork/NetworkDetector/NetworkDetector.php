<?php

namespace Criticalmass\Component\SocialNetwork\NetworkDetector;

use Criticalmass\Bundle\AppBundle\Entity\SocialNetworkProfile;
use Criticalmass\Component\SocialNetwork\Network\NetworkInterface;
use Criticalmass\Component\SocialNetwork\NetworkManager\NetworkManager;

class NetworkDetector
{
    /** @var NetworkManager $networkManager */
    protected $networkManager;

    /** @var array $networkList */
    protected $networkList = [];

    public function __construct(NetworkManager $networkManager)
    {
        $this->networkManager = $networkManager;
        $this->networkList = $networkManager->getNetworkList();

        $this->sortNetworkList();
    }

    public function detect(SocialNetworkProfile $socialNetworkProfile): ?NetworkInterface
    {
        /** @var NetworkInterface $network */
        foreach ($this->networkList as $network) {
            echo $network->getName();
            if ($network->accepts($socialNetworkProfile)) {
                return $network;
            }
        }

        return null;
    }

    protected function sortNetworkList(): NetworkDetector
    {
        usort($this->networkList, function(NetworkInterface $a, NetworkInterface$b)
        {
            return $b->getDetectorPriority() <=> $a->getDetectorPriority();
        });

        return $this;
    }
}