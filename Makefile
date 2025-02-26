# Makefile for managing the File-Server application

# Variables
PHP = php
COMPOSER = composer
NPM = npm
SAIL = ./vendor/bin/sail
DOCKER_COMPOSE = docker-compose

# Default target
.DEFAULT_GOAL := help

# Help target
help: ## Show this help message
	@echo "Usage: make [target]"
	@echo ""
	@echo "Targets:"
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}; {printf "  %-20s %s\n", $$1, $$2}'

# Application targets
install: ## Install dependencies
	$(COMPOSER) install
	$(NPM) install

migrate: ## Run database migrations
	$(PHP) artisan migrate

sail-up: ## Start the Docker containers
	$(SAIL) up

sail-seed: ## Seed the database with Sail
	$(SAIL) artisan db:seed
	
sail-migrate: ## Run database migrations with Sail
	$(SAIL) artisan migrate

sail-down: ## Stop the Docker containers
	$(SAIL) down

sail-test: ## Run tests with Sail
	$(SAIL) test

sail-versions: ## Display Sail versions
	$(SAIL) php --version
	$(SAIL) composer --version
	$(SAIL) npm --version

docker-build: ## Build Docker images
	$(DOCKER_COMPOSE) build

docker-up: ## Start Docker containers
	$(DOCKER_COMPOSE) up -d

docker-down: ## Stop Docker containers
	$(DOCKER_COMPOSE) down

docker-logs: ## View Docker logs
	$(DOCKER_COMPOSE) logs -f

key-generate: ## Generate application key
	$(PHP) artisan key:generate

serve: ## Start the development server
	$(PHP) artisan serve

test: ## Run tests
	$(PHP) artisan test

build: ## Build frontend assets
	$(NPM) run build

clean: ## Clean up the project
	rm -rf vendor
	rm -rf node_modules
	rm -rf storage/logs/*
	rm -rf storage/framework/cache/*
	rm -rf storage/framework/sessions/*
	rm -rf storage/framework/views/*
