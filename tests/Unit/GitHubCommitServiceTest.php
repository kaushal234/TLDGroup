<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\GitHubCommitService;
use Illuminate\Support\Facades\Http;

class GitHubCommitServiceTest extends TestCase
{
    private GitHubCommitService $gitHubCommitService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->gitHubCommitService = app()->make(GitHubCommitService::class);
    }

    /** @test */
    public function it_groups_commits_by_week()
    {
        Http::fake([
            'api.github.com/repos/facebook/react/commits*' => Http::response([
                [
                    'sha' => 'abc123',
                    'commit' => [
                        'author' => ['date' => '2025-12-08T12:00:00Z']
                    ]
                ],
                [
                    'sha' => 'def456',
                    'commit' => [
                        'author' => ['date' => '2025-12-09T12:00:00Z']
                    ]
                ],
            ], 200),
        ]);

        $result = $this->gitHubCommitService->fetchCommitsByWeek('facebook', 'react', '2025-12-01', '2025-12-31');

        $this->assertCount(1, $result);
        $this->assertEquals(2, $result[0]['count']);
        $this->assertEquals('abc123', $result[0]['commits'][0]['sha']);
    }

    /** @test */
    public function it_returns_empty_array_when_no_commits()
    {
        Http::fake([
            'api.github.com/repos/facebook/react/commits*' => Http::response([], 200),
        ]);

        $service = new GitHubCommitService();
        $result = $this->gitHubCommitService->fetchCommitsByWeek('facebook', 'react', '2025-12-01', '2025-12-31');

        $this->assertIsArray($result);
        $this->assertEmpty($result);
    }
}
