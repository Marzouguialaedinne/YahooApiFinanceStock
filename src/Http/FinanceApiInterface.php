<?php

namespace App\Http;

use Symfony\Component\HttpFoundation\JsonResponse;

interface FinanceApiInterface
{
	public function fetchProfile(string $symbol, string $region = 'US'): JsonResponse;

}