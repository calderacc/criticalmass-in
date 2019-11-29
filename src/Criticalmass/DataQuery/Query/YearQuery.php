<?php declare(strict_types=1);

namespace App\Criticalmass\DataQuery\Query;

use App\Criticalmass\DataQuery\Annotation\QueryAnnotation as DataQuery;
use App\Criticalmass\Util\DateTimeUtil;
use Symfony\Component\Validator\Constraints as Constraints;

/**
 * @DataQuery\RequiredEntityProperty(propertyName="dateTime", propertyType="DateTime")
 */
class YearQuery extends AbstractQuery implements ElasticQueryInterface, DoctrineQueryInterface
{
    /**
     * @Constraints\NotNull()
     * @Constraints\GreaterThanOrEqual(value="1990")
     * @Constraints\Type("int")
     * @var int $year
     */
    protected $year;

    /**
     * @Constraints\NotNull()
     * @Constraints\Type("string")
     * @var string $dateTimePattern
     */
    protected $dateTimePattern;

    /**
     * @Constraints\NotNull()
     * @Constraints\Type("string")
     * @var string $dateTimeFormat
     */
    protected $dateTimeFormat;

    /**
     * @Constraints\NotNull()
     * @Constraints\Type("string")
     * @var string $propertyName
     */
    protected $propertyName;

    public function setDateTimePattern(string $dateTimePattern): YearQuery
    {
        $this->dateTimePattern = $dateTimePattern;

        return $this;
    }

    public function setDateTimeFormat(string $dateTimeFormat): YearQuery
    {
        $this->dateTimeFormat = $dateTimeFormat;

        return $this;
    }

    public function setPropertyName(string $propertyName): YearQuery
    {
        $this->propertyName = $propertyName;

        return $this;
    }

    /**
     * @DataQuery\RequiredQueryParameter(parameterName="year")
     */
    public function setYear(int $year): YearQuery
    {
        $this->year = $year;

        return $this;
    }

    public function createElasticQuery(): \Elastica\Query\AbstractQuery
    {
        $fromDateTime = DateTimeUtil::getYearStartDateTime($this->toDateTime());
        $untilDateTime = DateTimeUtil::getYearEndDateTime($this->toDateTime());

        $dateTimeQuery = new \Elastica\Query\Range($this->propertyName, [
            'gte' => $fromDateTime->format($this->dateTimePattern),
            'lte' => $untilDateTime->format($this->dateTimePattern),
            'format' => $this->dateTimeFormat,
        ]);

        return $dateTimeQuery;
    }

    protected function toDateTime(): \DateTime
    {
        return new \DateTime(sprintf('%d-01-01 00:00:00', $this->year));
    }

    public function isOverridenBy(): array
    {
        return [
            MonthQuery::class,
            DateQuery::class,
        ];
    }
}
