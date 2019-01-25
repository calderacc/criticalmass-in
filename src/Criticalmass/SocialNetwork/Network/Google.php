<?php declare(strict_types=1);

namespace App\Criticalmass\SocialNetwork\Network;

use App\Entity\SocialNetworkProfile;

class Google extends AbstractNetwork
{
    protected $name = 'Google+';

    protected $icon = 'fa-google-plus';

    protected $backgroundColor = 'rgb(220, 78, 65)';

    protected $textColor = 'white';

    public function accepts(SocialNetworkProfile $socialNetworkProfile): bool
    {
        $pattern = '/^(https?\:\/\/)((www\.)?)(plus\.google\.com)\/\+([a-zA-Z0-9-]+)(\/?)$/';

        preg_match($pattern, $socialNetworkProfile->getIdentifier(), $matches);

        if ($matches && is_array($matches) && count($matches) > 1) {
            return true;
        }

        return false;
    }
}
