EventEase Backend
Overview
EventEase is a comprehensive platform designed to:

Help event planners find suitable venues for their events
Provide users with detailed information about weekend/holiday activities
Showcase special deals from various services (hotels, restaurants, etc.)

This repository contains the backend API for EventEase, built using Laravel.
Prerequisites

PHP >= 8.1
Composer
SQLite
Node.js & NPM (for asset compilation)
Laravel requirements as stated in the official documentation

Installation

### Clone the repository:
git clone https://github.com/your-organization/eventease-backend.git
cd eventease-backend

### Install dependencies:
composer install

### Create environment file:
cp .env.example .env

### Generate application key:
php artisan key:generate

###Configure SQLite in the .env file:
DB_CONNECTION=sqlite
DB_DATABASE=/absolute/path/to/database.sqlite

### Create SQLite database file:
touch database/database.sqlite

### Run migrations and seeders:
php artisan migrate --seed

### Start the development server:
php artisan serve
