<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About File-Server

File-Server is a web application built with Laravel that supports large file uploads up to 15GB. It allows users to upload, manage, and organize files into collections. The application provides features such as resumable uploads, file association with multiple collections, and the ability to remove associations or force delete files.

## Features

- Large file uploads up to 15GB
- Resumable uploads using Resumable.js
- Organize files into collections
- Remove file associations from collections
- Force delete files from the server
- User authentication and profile management

## Requirements

- PHP 8.2 or higher
- Composer
- Docker (for Laravel Sail)
- Node.js and npm

## Installation

1. Clone the repository:

    ```bash
    git clone https://github.com/aecwells/file-server.git
    cd file-server
    ```

2. Install dependencies:

    ```bash
    make install
    ```

3. Copy the `.env.example` file to `.env` and configure your environment variables:

    ```bash
    cp .env.example .env
    ```

4. Generate an application key:

    ```bash
    make key-generate
    ```

5. Run the database migrations:

    ```bash
    make migrate
    ```

6. Build the frontend assets:

    ```bash
    make build
    ```

## Development with Laravel Sail

Laravel Sail is a lightweight command-line interface for interacting with Laravel's default Docker development environment.

1. Install Laravel Sail:

    ```bash
    make sail-install
    ```

2. Start the Docker containers:

    ```bash
    make sail-up
    ```

3. Run the database migrations:

    ```bash
    make sail-migrate
    ```

4. Access the application in your browser at [http://localhost](http://localhost).

## Usage

### Uploading Files

1. Navigate to the upload page.
2. Enter an optional collection name.
3. Drag and drop your file into the drop zone or click to browse and select a file.
4. The upload progress will be displayed, and the file will be uploaded in chunks.

### Managing Files

1. Navigate to the files page to view all uploaded files.
2. Files are listed with their details, including name, size, MIME type, and upload date.
3. Each file can be downloaded, removed from a collection, or force deleted from the server.

### Collections

1. Files can be organized into collections.
2. Collections are displayed with their associated files.
3. Files can be removed from specific collections without deleting the file from the server.

## Routes

The application defines the following routes:

- **GET /**: Displays the welcome page.
- **GET /profile**: Displays the profile edit page.
- **PATCH /profile**: Updates the user's profile.
- **DELETE /profile**: Deletes the user's profile.
- **GET /upload**: Displays the file upload page.
- **GET /files**: Returns a JSON response with all uploaded files.
- **DELETE /files/{id}**: Removes a file association or deletes the file if it has no other associations.
- **DELETE /files/force/{id}**: Force deletes a file from the server.
- **DELETE /files/{mediaId}/collection/{collectionId}**: Removes a file association from a specific collection.
- **GET /dashboard**: Displays files grouped by collections.
- **GET /all-files**: Displays a list of all files with their details and actions.

## Artisan Commands

The application includes Artisan commands for managing common tasks. Here are some useful commands:

- `php artisan app:list-files`: List all uploaded files.
- `php artisan app:delete-file {file_id}`: Delete a file.
- `php artisan app:force-delete-file {file_id}`: Force delete a file from the server.
- `php artisan app:remove-file-association {file_id} {collection_id}`: Remove a file association from a specific collection.
- `php artisan app:list-grouped-files`: Display files grouped by collections.
- `php artisan app:list-all-files`: Display a list of all files with their details and actions.

## Development Container

The application supports development container environments. To use the development container, follow these steps:

1. Ensure you have Docker and Visual Studio Code installed.
2. Open the project in Visual Studio Code.
3. Press `F1` and select `Remote-Containers: Open Folder in Container...`.
4. Select the project folder.
5. The development container will be built and started automatically.

## Makefile

The Makefile includes common tasks for managing the application. Here are some useful commands:

- `make install`: Install PHP and Node.js dependencies.
- `make migrate`: Run database migrations.
- `make sail-install`: Install Laravel Sail.
- `make sail-up`: Start the Docker containers.
- `make sail-migrate`: Run database migrations with Sail.
- `make sail-down`: Stop the Docker containers.
- `make sail-test`: Run tests with Sail.
- `make sail-versions`: Display Sail versions.
- `make key-generate`: Generate an application key.
- `make serve`: Start the development server.
- `make test`: Run tests.
- `make build`: Build frontend assets.
- `make clean`: Clean up the project.

## License

File-Server is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
