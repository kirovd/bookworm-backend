# Backend (Bookworm API)

This project is a Laravel-based backend API for managing books and user favorites.

## Prerequisites

Ensure you have the following software installed on your machine:

- PHP (v7.4 or higher)
- Composer
- MySQL
- XAMPP (for local development with Apache and MySQL)

## Setup

1. **Clone the repository**:

    ```bash
    git clone https://github.com/yourusername/bookworm-backend.git
    cd bookworm-backend
    ```

2. **Install dependencies**:

    ```bash
    composer install
    ```

3. **Environment configuration**:
    - Copy `.env.example` to `.env`:

        ```bash
        cp .env.example .env
        ```

    - Update the `.env` file with your database credentials and other necessary configurations.

4. **Generate application key**:

    ```bash
    php artisan key:generate
    ```

5. **Run database migrations**:

    ```bash
    php artisan migrate
    ```

6. **Seed the database** (optional, if you have seeders):

    ```bash
    php artisan db:seed
    ```

7. **Run the local development server**:

    ```bash
    php artisan serve
    ```

    The API will be accessible at [http://localhost:8000](http://localhost:8000).


## API Documentation

API documentation is generated using Swagger. To generate the API documentation:

1. **Generate Swagger documentation**:

    ```bash
    php artisan l5-swagger:generate
    ```

2. **View the documentation**:
   
    Visit [http://localhost:8000/docs](http://localhost:8000/docs) to view the API documentation.
