# Actor Submission System

A Laravel application that collects actor information through a web form and extracts structured data using OpenAI API.

## Features

- Web form for submitting actor information (email and description)
- OpenAI API integration to extract structured data: first name, last name, address, height, weight, gender, age
- Email and description uniqueness validation
- Required fields validation for firstName, lastName, and address
- Table view displaying all submissions
- API endpoint for retrieving the AI prompt
- Localized messages (English)
- Docker environment with automated migrations

## Requirements

- Docker Desktop
- OpenAI API key

## Installation

1. Clone the repository

2. Copy `.env.example` to `.env`:
```bash
cp .env.example .env
```

3. Add your OpenAI API key to `.env`:
```
OPENAI_API_KEY=your_api_key_here
```

4. Build and start Docker containers:
```bash
docker-compose up -d --build
```

The application will automatically:
- Wait for MySQL to be ready
- Run database migrations
- Start the application

## Usage

- **Submit Form**: Navigate to `http://localhost` to access the submission form
- **View Submissions**: Navigate to `http://localhost/actors` to view all submissions
- **phpMyAdmin**: Navigate to `http://localhost:8080` to manage the MySQL database
- **API Endpoint**: `GET /api/actors/prompt-validation` returns the OpenAI prompt used for data extraction

## Docker Commands

```bash
# Start containers
docker-compose up -d

# Stop containers
docker-compose down

# View logs
docker-compose logs -f

# Rebuild containers
docker-compose up -d --build

# Run tests
docker-compose exec app php artisan test

# Access container shell
docker-compose exec app bash
```

## Project Structure

- **Controllers**: `app/Http/Controllers/ActorController.php`
- **Models**: `app/Models/Actor.php`
- **Services**: `app/Services/ActorExtractionService.php`
- **Form Requests**: `app/Http/Requests/StoreActorRequest.php`
- **API Resources**: `app/Http/Resources/ActorResource.php`
- **Views**: `resources/views/actors/`
- **Migrations**: `database/migrations/`
- **Localization**: `lang/en/messages.php`
- **Configuration**: `config/ai.php`
- **Docker**: `docker/startup.sh` (automated startup script)

## Testing

Run tests with:
```bash
docker-compose exec app php artisan test
```

## Technologies

- Laravel 12
- PHP 8.4
- MySQL 8
- phpMyAdmin (latest)
- OpenAI API (gpt-4o-mini)
- Tailwind CSS
- Docker & Docker Compose
