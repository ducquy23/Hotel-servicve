# FuelPHP Docker Makefile

.PHONY: help build up down restart logs shell db-shell migrate clean

# Default target
help:
	@echo "FuelPHP Docker Commands:"
	@echo "  make build     - Build Docker images"
	@echo "  make up        - Start all services"
	@echo "  make down      - Stop all services"
	@echo "  make restart   - Restart all services"
	@echo "  make logs      - Show logs"
	@echo "  make shell     - Access PHP container shell"
	@echo "  make db-shell  - Access MySQL shell"
	@echo "  make migrate   - Run FuelPHP migrations"
	@echo "  make clean     - Clean up containers and volumes"

# Build images
build:
	docker-compose build --no-cache

# Start services
up:
	docker-compose up -d

# Stop services
down:
	docker-compose down

# Restart services
restart: down up

# Show logs
logs:
	docker-compose logs -f

# Access PHP container
shell:
	docker-compose exec php bash

# Access MySQL shell
db-shell:
	docker-compose exec mysql mysql -u fuelphp_user -p fuelphp_db

# Run migrations
migrate:
	docker-compose exec php php oil migrate

# Clean up
clean:
	docker-compose down -v
	docker system prune -f

# Setup everything
setup:
	chmod +x docker-setup.sh
	./docker-setup.sh
