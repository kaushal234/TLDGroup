<?php

namespace App\Services;

use App\Contracts\CommitFetcherInterface;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class GitHubCommitService implements CommitFetcherInterface
{
    protected string $baseUrl;
    protected string $defaultBranch;
    protected int $perPage;

    public function __construct()
    {
        $this->baseUrl = config('services.github.base_url');
        $this->defaultBranch = config('services.github.default_branch');
        $this->perPage = config('services.github.per_page', 100);
    }
    /**
     * Fetch commits from GitHub and group them by week.
     */
    public function fetchCommitsByWeek(string $user, string $repository, ?string $since, ?string $until): array
    {
        $allCommits = [];
        $page = 1;

        do {
            $commits = $this->fetchCommitsPage($user, $repository, $since, $until, $page);
            if (isset($commits['error'])) {
                return $commits;
            }

            foreach ($commits as $commit) {
                $allCommits[] = $commit;
            }

            $page++;
        } while (count($commits) === $this->perPage);

        return $this->groupCommitsByWeek($allCommits);
    }

    /**
     * Fetch a singlae page of commits from GitHub.
     */
    private function fetchCommitsPage(string $user, string $repository, ?string $since, ?string $until, int $page): array
    {
        $url = "{$this->baseUrl}/repos/{$user}/{$repository}/commits";

        $query = [
            'sha' => $this->defaultBranch,
            'per_page' => $this->perPage,
            'page' => $page,
        ];

        if ($since) {
            $query['since'] = Carbon::parse($since)->startOfDay()->toIso8601String();
        }

        if ($until) {
            $query['until'] = Carbon::parse($until)->endOfDay()->toIso8601String();
        }

        try {
            $response = Http::get($url, $query);

            if ($response->failed()) {
                Log::error("GitHub API request failed", [
                    'url' => $url,
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);

                return ['error' => 'Unable to fetch commits from GitHub.'];
            }

            return $response->json();

        } catch (\Exception $e) {
            Log::error("GitHub API Exception: ".$e->getMessage());
            return ['error' => 'Exception occurred while fetching commits.'];
        }
    }

    /**
     * Group commits by calendar week.
     */
    private function groupCommitsByWeek(array $commits): array
    {
        $grouped = [];

        foreach ($commits as $commit) {
            $date = Carbon::parse($commit['commit']['author']['date']);
            $week = $date->weekOfYear;

            if (!isset($grouped[$week])) {
                $grouped[$week] = [
                    'week' => $week,
                    'count' => 0,
                    'commits' => [],
                ];
            }

            $grouped[$week]['commits'][] = $commit;
            $grouped[$week]['count']++;
        }

        return array_values($grouped);
    }
}
