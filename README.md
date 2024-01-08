# Funds Backend - Laravel Application

Welcome to the Funds Backend Laravel application! This document provides instructions for setting up and running the application.

## Getting Started

1. **Clone the Project:**
   ```bash
   git clone git@github.com:andreurbanski/remotely-funds.git && cd remotely-funds && cp src/.env.example src/.env
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

6. **Use the application endpoints**

    There is a .collection.json file containing a Postman collection with all the application enpoints and examples of use.
    You just need to import it into Postman, set the {{funds_host}} variable to http://127.0.0.1:7777/api

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

## System Usage

 
 To start using this application you car import the Postman collection into your local Postman instalation containing all the available Endpoints with examples of usage. Remember to update the UUIDs during the creation of the relations.

 You must define the entities on the following order:
 1. Company
 2. Manager
 3. Fund

 At the queue for duplicated Funds, you can observe it working by creating multiple funds with either "name" or "alias" entry duplicated. The system will perform a Intersection and once found will start the Queue that you write into the file "/app/storage/logs/duplication.log" all intersected items.

## Contributors

- [Andre Urbanski](https://github.com/andreurbanski)

Feel free to contribute to this project by opening issues, submitting pull requests, or providing feedback!

Happy coding! 🚀
```