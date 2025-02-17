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

- PHP 8.0 or higher
- Composer
- Docker (for Laravel Sail)

## Installation

1. Clone the repository:

    ```bash
    git clone https://github.com/aecwells/file-server.git
    cd file-server
    ```

2. Install dependencies:

    ```bash
    composer install
    ```

3. Copy the `.env.example` file to `.env` and configure your environment variables:

    ```bash
    cp .env.example .env
    ```

4. Generate an application key:

    ```bash
    php artisan key:generate
    ```

5. Run the database migrations:

    ```bash
    php artisan migrate
    ```

## Development with Laravel Sail

Laravel Sail is a lightweight command-line interface for interacting with Laravel's default Docker development environment.

1. Install Laravel Sail:

    ```bash
    composer require laravel/sail --dev
    ```

2. Start the Docker containers:

    ```bash
    ./vendor/bin/sail up
    ```

3. Run the database migrations:

    ```bash
    ./vendor/bin/sail artisan migrate
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

## Contributing

Thank you for considering contributing to the File-Server project! Please read the [contribution guide](https://laravel.com/docs/contributions) for details on how to contribute.

## Security Vulnerabilities

If you discover a security vulnerability within File-Server, please send an e-mail to the project maintainer. All security vulnerabilities will be promptly addressed.

## License

File-Server is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
