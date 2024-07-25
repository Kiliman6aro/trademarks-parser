<?php

namespace HopHey\Trademarks\Contract\Services;

interface SearchServiceContract
{
    public function search(string $searchTerm): array;
}