## SoftLite test project

Requires the following technologies be installed on the hosting server:

- Composer
- Docker, Docker Compose
- Laravel 10
- PHP 8.2
- PostgreSQL
- Redis

### Installation guide

1. Clone the repository:

   ```bash
   git clone <repository-url>
   cd <repository-directory>
2. Copy the `.env.example` file to `.env`:
    ```bash
    cp .env.example .env
3. Install dependencies:
    ```bash
    composer install
4. Start the containers:
    ```bash
   docker-compose up -d
5. Generate keys for application:
    ```bash
    php artisan key:generate

6. Run migrations and seed the database:
    ```bash
    php artisan migrate:fresh --seed

### That's it! After these steps, the service will:

Automatically build and start all required Docker containers.
Perform migrations and seed the database with test data, including:
#### A test user with the following credentials:
- Email: admin@admin.com
- Password: password

Predefined categories, countries, and product statuses.
The API should be available at:
http://localhost/api/v1

### Working with Laravel Sail
This project uses Laravel Sail for local development. 
You can access the Laravel Sail environment and run Artisan commands using the following:

Enter the application container:
```bash
./vendor/bin/sail shell
```

### Pusher websocket broadcasting
If you need to use Pusher for broadcasting, change the 
BROADCAST_DRIVER to pusher in the .env file and provide your Pusher credentials accordingly.
