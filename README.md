# TLD GitHub Commits Weekly Analyzer

## 1. Project Overview

### 1.1 Purpose
This project was developed as part of a technical interview exercise.  
Its purpose is to demonstrate the ability to consume a third-party REST API, process and transform data, and expose a clean JSON endpoint using Laravel.

### 1.2 Scope
The application focuses on retrieving commits from public GitHub repositories and grouping them by calendar week within a given date range.

---

## 2. Description

### 2.1 What the Application Does
The application fetches commits from the GitHub REST API for a specified repository and groups them by ISO calendar week, returning both the total number of commits and the commit details for each week.

### 2.2 Key Objectives
- Consume the GitHub REST API  
- Apply date filtering using query parameters  
- Group data by calendar week  
- Return structured JSON responses  
- Follow clean and testable Laravel architecture  

---

## 3. Badges

### 3.1 Status Badges
No badges are included in this repository.  
This project is intended for interview evaluation purposes only and not for public open-source distribution.

---

## 4. Visuals

### 4.1 User Interface
This project does not include a graphical user interface.  
All interactions are performed through HTTP requests, and responses are returned in JSON format.

---

## 5. Installation

### 5.1 Requirements
- PHP 8.1 or higher  
- Composer  
- Laravel (latest stable version)  
- Internet connection (for GitHub API access)

### 5.2 Setup Steps
1. Clone the repository:  
```bash
git clone https://github.com/kaushal234/TLDGroup.git
cd TLDGroup
```
2. Install dependencies:  
```bash
composer install
```

---

## 6. Usage

### 6.1 Running the Application
Start the Laravel development server:  
```bash
php artisan serve
```
The application will be available at:  
```
http://localhost:8000
```

### 6.2 API Endpoint
```
GET /{user}/{repository}
```

### 6.3 Query Parameters
| Parameter | Required | Description               |
|-----------|----------|---------------------------|
| since     | No       | Start date (YYYY-MM-DD)  |
| until     | No       | End date (YYYY-MM-DD)    |

**Default behavior:**  
- `since`: 4 weeks before the current date  
- `until`: current date  

### 6.4 Example Request
```bash
curl "http://localhost:8000/facebook/react?since=2024-01-01&until=2024-02-01"
```

### 6.5 Example Response
```json
[
  {
    "week": 1,
    "count": 10,
    "commits": []
  },
  {
    "week": 2,
    "count": 8,
    "commits": []
  }
]
```

---

## 7. Support

### 7.1 Support Policy
This project was created exclusively for a technical interview.  
No long-term support or maintenance is provided beyond the evaluation process.

---

## 8. Roadmap

### 8.1 Planned Improvements
Given more time, the following improvements could be implemented:
- GitHub API pagination handling  
- Rate-limit detection using GitHub response headers  
- Caching GitHub API responses using Laravel’s cache system  
- Improved error handling and edge-case validation  
- Additional unit and feature tests  

---

## 9. Contributing

### 9.1 Contribution Policy
This repository is not open to external contributions.  
It was created solely for evaluation purposes as part of a technical interview.

---

## 10. Authors and Acknowledgment

### 10.1 Author
Developed by the candidate as part of a technical interview for TLD Group.

### 10.2 Acknowledgment
- GitHub REST API documentation  
- Laravel official documentation  

---

## 11. License

### 11.1 Licensing
No license is applied to this project.  
The code is provided strictly for interview evaluation purposes and is not intended for reuse or redistribution.

---

## 12. Project Status

### 12.1 Current State
The project is considered complete within the scope of the technical interview.  
Further development was intentionally limited to respect the time constraints of the exercise.

