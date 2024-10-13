#!/bin/bash

# exit script if any command fails
set -e

# clear terminal
clear

echo "-------------------------------------"
echo "Laravel Docker + Inertia.js Installer"
echo "-------------------------------------"

# [Step 0] => Check if Docker is installed
if ! [ -x "$(command -v docker)" ]; then
  echo "Error: Docker is not installed." >&2
  exit 1
fi

# [Step 1] => Check if sail is installed, and install composer dependencies if necessary
if [ ! -f "vendor/bin/sail" ]; then
    echo "Step 1: Installing Composer dependencies..."
    docker run --rm \
        -u "$(id -u):$(id -g)" \
        -v "$(pwd):/var/www/html" \
        -w /var/www/html \
        laravelsail/php82-composer:latest \
        composer install --ignore-platform-reqs
fi

# [Step 2] => Bring up docker containers with sail
echo "Step 2: Bringing up Docker containers..."
./vendor/bin/sail up -d

# [Step 3] => Wait for the containers to be ready
echo ""
echo "Waiting for the containers to be ready..."
sleep 20

# [Step 4] => Copy .env.example to .env if not exists
if [ ! -f ".env" ]; then
    echo "Step 4: Copying .env.example to .env..."
    cp .env.example .env
    echo "Generating application key..."
    ./vendor/bin/sail artisan key:generate
fi

# [Step 5] => Run database migrations
echo "Step 5: Running database migrations..."
./vendor/bin/sail artisan migrate

# [Step 6] => Run database seeders
echo "Step 6: Seeding the database..."
./vendor/bin/sail artisan db:seed

# [Step 7] => Install npm dependencies
echo "Step 7: Installing NPM dependencies..."
./vendor/bin/sail npm install

# [Step 8] => Build frontend assets
echo "Step 8: Building frontend assets..."
./vendor/bin/sail npm run build

# [Step 9] => Start the queue worker (to process jobs)
echo "Step 9: Starting queue worker..."
./vendor/bin/sail artisan queue:work --daemon &

# [Step 10] => Run a health check on the application
echo "Step 10: Checking if the app is up and running..."
./vendor/bin/sail artisan route:list

# DONE !!!
echo "-------------------------------------"
echo "Installation complete!"
echo "-------------------------------------"
echo "You can now access the app at http://localhost"
