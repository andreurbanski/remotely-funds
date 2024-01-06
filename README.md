Certainly! Below is a template for your `readme.md` file for a Laravel application called `funds-backend`. Make sure to customize it further based on your specific application details.

```markdown
# Funds Backend - Laravel Application

Welcome to the Funds Backend Laravel application! This document provides instructions for setting up and running the application.

## Getting Started

1. **Clone the Project:**
   ```bash
   git clone git@github.com:andreurbanski/remotely-funds.git && cd remotely-funds
   ```

2. **Start the Docker Container:**
   ```bash
   docker-compose --env-file src/.env up --build
   ```
   This command starts the Docker containers using the specified environment file (`src/.env`).

3. **Start the Job Queue:**
   ```bash
   sh run.sh queue
   ```
   Use this command to start the job queue for handling asynchronous tasks.

4. **Test the Application:**
   ```bash
   sh run.sh test
   ```
   Run this command to execute the application tests.

5. **Create Initial Database and Migrations:**
   ```bash
   sh run.sh create
   ```
   Execute this command to create the initial database and run migrations.

## Additional Commands

- **Stop Docker Containers:**
  ```bash
  docker-compose down
  ```
  Use this command to stop and remove the Docker containers.

- **View Docker Container Logs:**
  ```bash
  docker-compose logs -f
  ```
  View real-time logs of the running Docker containers.

- **Access Docker Container Shell:**
  ```bash
  docker-compose exec app bash
  ```
  Access the shell of the `app` container to perform manual tasks or debugging.

## Environment Variables

Make sure to configure the necessary environment variables in the `.env` file or `.env.example` based on your project requirements.

## Contributors

- [Andre Urbanski](https://github.com/andreurbanski)

Feel free to contribute to this project by opening issues, submitting pull requests, or providing feedback!

Happy coding! 🚀
```