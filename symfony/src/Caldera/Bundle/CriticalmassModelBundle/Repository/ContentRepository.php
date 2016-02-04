<?php

namespace Caldera\Bundle\CriticalmassModelBundle\Repository;

use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityRepository;

class ContentRepository extends EntityRepository
{
    public function findBySlug($slug)
    {
        $content = $this->findBy(
            [
                'slug' => $slug,
                'enabled' => true,
                'isArchived' => false
            ]
        );

        return $content;
    }
}

