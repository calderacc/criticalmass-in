<?php

namespace Caldera\CriticalmassBundle\Utility\PositionFilter\SimplePositionFilter;

use Caldera\CriticalmassBundle\Entity as Entity;

/**
 * Dieser Filter entfernt alle Positionsdaten, die vom jeweiligen Client nicht
 * als hinreichend genau eingestuft worden sind.
 */
class AccuracyPositionFilter extends SimplePositionFilter
{
	/**
	 * {@inheritDoc}
	 */
	public function buildQuery($queryBuilder)
	{
		return $queryBuilder->andWhere("p.accuracy <= 100");
	}
}