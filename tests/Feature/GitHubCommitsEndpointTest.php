<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Services\GitHubCommitService;
use Illuminate\Support\Facades\App;

class GitHubCommitsEndpointTest extends TestCase
{
    private GitHubCommitService $gitHubCommitService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->gitHubCommitService = app()->make(GitHubCommitService::class);
    }

    /** @test */
    public function it_returns_commits_grouped_by_week()
    {
        $mock = $this->createMock(GitHubCommitService::class);

        $mock->method('fetchCommitsByWeek')
             ->willReturn([
                 [
                     'week' => 50,
                     'count' => 2,
                     'commits' => [
                         ['sha' => 'abc123', 'commit' => ['author' => ['date' => '2025-12-10T12:00:00Z']]],
                         ['sha' => 'def456', 'commit' => ['author' => ['date' => '2025-12-11T12:00:00Z']]],
                     ],
                 ],
             ]);

        App::instance(GitHubCommitService::class, $mock);

        $response = $this->getJson('/api/facebook/react?since=2025-12-01&until=2025-12-31');

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     '*' => ['week', 'count', 'commits']
                 ])
                 ->assertJsonFragment(['week' => 50, 'count' => 2]);
    }

    /** @test */
    public function it_returns_422_when_until_is_invalid()
    {
        $response = $this->getJson('/api/facebook/react?until=invalid-date');

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['until']);
    }

    /** @test */
    public function it_uses_default_dates_if_parameters_missing()
    {
        $mock = $this->createMock(GitHubCommitService::class);

        $mock->method('fetchCommitsByWeek')
             ->willReturn([]);

        App::instance(GitHubCommitService::class, $mock);

        $response = $this->getJson('/api/facebook/react');

        $response->assertStatus(200)
                 ->assertExactJson([]);
    }
}
