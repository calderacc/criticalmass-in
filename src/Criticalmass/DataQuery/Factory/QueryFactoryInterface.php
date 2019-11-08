<?php declare(strict_types=1);

namespace App\Criticalmass\DataQuery\Factory;

use Symfony\Component\HttpFoundation\Request;

interface QueryFactoryInterface
{
    public function createFromRequest(Request $request): array;
}