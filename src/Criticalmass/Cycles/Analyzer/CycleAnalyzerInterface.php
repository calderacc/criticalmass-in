<?php declare(strict_types=1);

namespace App\Criticalmass\Cycles\Analyzer;

use App\Entity\City;

interface CycleAnalyzerInterface
{
    public function setCity(City $city): CycleAnalyzerInterface;
    public function analyze(): CycleAnalyzerInterface;
    public function getResultList(): array;
}
