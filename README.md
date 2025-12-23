
# Project Title

A brief description of what this project does and who it's for

TLD GitHub Commits Weekly Analyzer (Laravel)
Description

This project is a Laravel application developed as part of a technical interview test.
It retrieves commits from the GitHub REST API for a given public repository and groups them by calendar week within a specified date range.

The application exposes a single HTTP endpoint that returns commit data in JSON format, including the number of commits and the list of commits for each week.

Features

Fetch commits from public GitHub repositories

Filter commits by date range (since, until)

Default date range: last 4 weeks

Group commits by ISO calendar week

JSON API response

Clean architecture with separated business logic

Unit and feature tests

Tech Stack

PHP >= 8.1

Laravel (latest stable version)

Laravel HTTP Client (Guzzle)

PHPUnit

Installation
1. Clone the repository
git clone <repository-url>
cd <project-folder>

2. Install dependencies
composer install

3. Environment setup
cp .env.example .env
php artisan key:generate


No GitHub authentication is required (only public repositories are used).

Running the Application

Start the Laravel development server:

php artisan serve


The application will be available at:

http://localhost:8000

API Endpoint
Route
GET /{user}/{repository}

Query Parameters
Parameter	Required	Description
since	No	Start date (YYYY-MM-DD)
until	No	End date (YYYY-MM-DD)

Default values

since: 4 weeks ago

until: today

Example Request
curl "http://localhost:8000/facebook/react?since=2024-01-01&until=2024-02-01"

Example Response
[
  {
    "week": 1,
    "count": 10,
    "commits": [
      {
        "sha": "abc123",
        "commit": {
          "author": {
            "name": "John Doe",
            "date": "2024-01-03T10:15:30Z"
          },
          "message": "Fix bug"
        }
      }
    ]
  },
  {
    "week": 2,
    "count": 8,
    "commits": []
  }
]

Project Structure

Controller

Handles HTTP requests and responses

Service Layer

Responsible for calling the GitHub API

Business Logic

Groups commits by calendar week

This structure improves testability and maintainability.

Testing

Run the test suite with:

php artisan test


Rate limiting and caching were not implemented due to time constraints.

To improve this project, GitHub API rate-limit headers could be handled to detect when the limit is reached and return a proper error response, or by using an authenticated GitHub token to increase the allowed number of requests. In addition, Laravel’s cache system could be used to cache GitHub API responses based on the repository and date range, reducing the number of external API calls and improving performance.

Author

Kaushal Hirani
