#!/bin/bash

# Define Docker container name
APP_CONTAINER_NAME="remotely-funds-backend"
DB_CONTAINER_NAME="remotely-funds-postgres"

if [ -f src/.env ]; then
        export $(cat ./src/.env | grep -v '#' | awk '/=/ {print $1}')
fi

# Function to run commands inside the Docker container
backend_exec() {
    docker exec -it "$APP_CONTAINER_NAME" "$@"
}

db_exec() {
    docker exec -it "$DB_CONTAINER_NAME" "$@"
}

# Test command
test_command() {
    echo "Creating test database..."
    echo createdb  -U $DB_USERNAME $DB_DATABASE
    db_exec createdb  $DB_TEST_DATABASE

    echo "Running tests..."
    backend_exec php artisan test

     echo "Destroy the test database..."
    echo psql -c "DROP DATABASE IF EXISTS $DB_TEST_DATABASE;"
    db_exec psql -c "DROP DATABASE IF EXISTS $DB_TEST_DATABASE;"
}

# Run command
start_command() {
    echo "Running Laravel application..."
    docker-compose up -d
    backend_exec php artisan serve --host=0.0.0.0 --port=7777
}

# Queue listen command
queue_listen_command() {
    echo "Starting queue listener..."
    backend_exec php artisan queue:listen
}

# Create database command
create_database_command() {
    # Load environment variables from the .env file
   
    echo "Creating database funds_backend..."
    echo createdb  $DB_DATABASE
    db_exec createdb $DB_DATABASE

    echo "Running migrations for working DB..."
    backend_exec php artisan migrate

}

# Parse command parameter
command=$1

# Main menu
case $command in
    "test")
        test_command
        ;;
    "start")
        start_command
        ;;
    "queue")
        queue_listen_command
        ;;
    "create")
        create_database_command
        ;;
    *)
        echo "Invalid command. Usage: $0 <test|start|queue|create
        exit 1
        ;;
esac
