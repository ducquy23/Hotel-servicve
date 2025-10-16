# FuelPHP Docker Setup

Docker configuration cho dự án FuelPHP với PHP-FPM + Nginx + MySQL.

## 🚀 Quick Start

### 1. Chạy setup tự động
```bash
chmod +x docker-setup.sh
./docker-setup.sh
```

### 2. Hoặc chạy thủ công
```bash
# Build và start containers
make build
make up

# Chạy migrations
make migrate
```

## 📋 Services

- **Nginx**: Web server (Port 8001)
- **PHP-FPM**: PHP processor (Port 9000)
- **MySQL**: Database (Port 3306)
- **phpMyAdmin**: Database management (Port 8080)
- **Redis**: Cache (Port 6379)

## 🔧 Commands

### Docker Compose
```bash
# Start services
docker-compose up -d

# Stop services
docker-compose down

# View logs
docker-compose logs -f

# Restart services
docker-compose restart
```

### Make commands
```bash
make build     # Build images
make up        # Start services
make down      # Stop services
make restart   # Restart services
make logs      # Show logs
make shell     # Access PHP container
make db-shell  # Access MySQL shell
make migrate   # Run migrations
make clean     # Clean up
```

## 🌐 Access URLs

- **Website**: http://localhost:8001
- **Admin Panel**: http://localhost:8001/admin
- **phpMyAdmin**: http://localhost:8080

## 📁 Directory Structure

```
docker/
├── nginx/
│   ├── nginx.conf
│   └── default.conf
├── php/
│   ├── php.ini
│   └── php-fpm.conf
└── mysql/
    └── init.sql
```

## ⚙️ Configuration

### PHP Settings
- **Memory Limit**: 256M
- **Max Execution Time**: 300s
- **Upload Max Filesize**: 20M
- **Post Max Size**: 20M

### Nginx Settings
- **Client Max Body Size**: 20M
- **Gzip Compression**: Enabled
- **Static File Caching**: 1 year

### MySQL Settings
- **Database**: fuelphp_db
- **User**: fuelphp_user
- **Password**: fuelphp_password

## 🐛 Troubleshooting

### Container không start
```bash
# Check logs
docker-compose logs

# Rebuild containers
make clean
make build
make up
```

### Permission issues
```bash
# Fix permissions
sudo chmod -R 777 fuel/app/cache
sudo chmod -R 777 fuel/app/logs
sudo chmod -R 777 fuel/app/tmp
sudo chmod -R 777 public/uploads
```

### Database connection issues
```bash
# Check MySQL logs
docker-compose logs mysql

# Access MySQL shell
make db-shell
```

## 🔒 Security Notes

- Change default passwords in production
- Use environment variables for sensitive data
- Enable SSL/TLS in production
- Regular security updates

## 📚 Additional Resources

- [FuelPHP Documentation](https://fuelphp.com/docs/)
- [Docker Documentation](https://docs.docker.com/)
- [Nginx Documentation](https://nginx.org/en/docs/)
