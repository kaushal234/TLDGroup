<?php

namespace App\Contracts;

interface CommitFetcherInterface
{
    public function fetchCommitsByWeek(string $user, string $repository, ?string $since, ?string $until): array;
}
