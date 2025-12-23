<?php

namespace App\Http\Controllers;

use App\Services\GitHubCommitService;
use App\Http\Requests\GitHubCommitRequest;
use Illuminate\Http\JsonResponse ;

class GithubCommitController extends Controller
{
    protected $gitHubCommitService;

    // Inject the service via constructor
    public function __construct(GitHubCommitService $gitHubCommitService)
    {
        $this->gitHubCommitService = $gitHubCommitService;
    }

    /**
     * Get GitHub commits grouped by week.
     */
    public function index(GitHubCommitRequest $request, string $user, string $repository) : JsonResponse
    {
        $validated = $request->validatedData();

        $commitsByWeek = $this->gitHubCommitService->fetchCommitsByWeek(
            $user,
            $repository,
            $validated['since'],
            $validated['until']
        );

        if (isset($commitsByWeek['error'])) {
            return response()->json($commitsByWeek, 500);
        }

        return response()->json($commitsByWeek);
    }
}
