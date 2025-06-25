# Define the content of the README.md file
readme_content = """# Laravel Project with Passport Authentication and Post CRUD

This project is a Laravel-based web application that implements user authentication using Laravel Passport and provides CRUD operations for a Post model using the Repository Design Pattern.

## Features

- **Authentication with Laravel Passport**
  - User registration
  - User login
  - User logout
  - Secure API authentication using OAuth2

- **Post Management**
  - Create, Read, Update, and Delete (CRUD) operations for posts
  - Implementation using the Repository Design Pattern for better code organization and testability

## Setup Instructions

### 1. Clone the Repository

git clone https://github.com/NourAlah/demos-proj.git

### 2. Install dependencies

composer install 

### 3. Environment setup

cp .env.example .env

### 4. Configure Database

Update your .env file with your database credentials.

### 5. Run Migrations

php artisan migrate

### 6. Install Laravel Passport

php artisan passport:install

### 7. Configure Passport

- In AuthServiceProvider, add: 

use Laravel\\Passport\\Passport;

public function boot()
{
    $this->registerPolicies();
    Passport::routes();
}

- In config/auth.php, set the API driver to passport:

'guards' => [
    'api' => [
        'driver' => 'passport',
        'provider' => 'users',
    ],
],


### 8. Serve the Application

php artisan serve



## API Endpoints

- **Authentication**
- POST /api/register – Register a new user
- POST /api/login – Login and receive access token
- POST /api/logout – Logout the user

- **Posts**
- GET /api/posts – List all posts
- GET /api/posts/{id} – Get a single post
- POST /api/posts – Create a new post
- PUT /api/posts/{id} – Update a post
- DELETE /api/posts/{id} – Delete a post

- **Repository Pattern Structure**
- App\Repositories\PostRepositoryInterface
- App\Repositories\PostRepository
- App\Http\Controllers\PostController uses the repository for data access


