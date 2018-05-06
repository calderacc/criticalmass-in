<?php declare(strict_types=1);

namespace Criticalmass\Component\Profile\ParticipationTable;

use Criticalmass\Bundle\AppBundle\Entity\Participation;

class ParticipationYear implements \Countable
{
    /** @var int $year */
    protected $year;

    /** @var array $monthList */
    protected $monthList;

    public function __construct(int $year)
    {
        $this->year = $year;

        $this->initMonthList();
    }

    protected function initMonthList(): ParticipationYear
    {
        for ($month = 1; $month <= 12; ++$month) {
            $this->monthList[$month] = new ParticipationMonth($this->year, $month);
        }

        return $this;
    }

    public function addParticipation(Participation $participation): ParticipationYear
    {
        $ride = $participation->getRide();
        $dateTime = $ride->getDateTime();
        $month = (int) $dateTime->format('n');

        $this->monthList[$month]->addParticipation($participation);

        return $this;
    }

    public function count(): int
    {
        $counter = 0;

        for ($month = 1; $month <= 12; ++$month) {
            $counter += count($this->monthList[$month]);
        }

        return $counter;
    }

    public function getMonthList(): array
    {
        return $this->monthList;
    }

    public function getYear(): int
    {
        return $this->year;
    }
}