-- Initialize database
-- This file runs automatically when MySQL container starts for the first time

-- Create database if not exists (already handled by environment variable, but just in case)
CREATE DATABASE IF NOT EXISTS `pengelolaan_barang_pamtech` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Grant privileges
GRANT ALL PRIVILEGES ON `pengelolaan_barang_pamtech`.* TO 'laravel'@'%';
FLUSH PRIVILEGES;
