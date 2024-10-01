#!/bin/bash

if [ ! -f .env ]; then
    cp .env.example .env
    echo ".env file copied from .env.example"
fi

./vendor/bin/sail composer install
./vendor/bin/sail artisan key:generate
./vendor/bin/sail artisan migrate --seed

echo "Migrations and seeders are complete."
