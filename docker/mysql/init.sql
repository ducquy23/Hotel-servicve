-- Tạo database nếu chưa tồn tại
CREATE DATABASE IF NOT EXISTS fuelphp_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Tạo user nếu chưa tồn tại
CREATE USER IF NOT EXISTS 'fuelphp_user'@'%' IDENTIFIED BY 'fuelphp_password';

-- Cấp quyền cho user
GRANT ALL PRIVILEGES ON fuelphp_db.* TO 'fuelphp_user'@'%';

-- Flush privileges
FLUSH PRIVILEGES;

-- Sử dụng database
USE fuelphp_db;

-- Tạo bảng cơ bản nếu cần
-- (Các bảng sẽ được tạo bởi FuelPHP migrations)
