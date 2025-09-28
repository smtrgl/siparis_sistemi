-- siparis_sistemi.sql

-- ----------------------------
-- Table structure for companies
-- ----------------------------
CREATE TABLE `companies` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(255) NOT NULL,
  `slug` VARCHAR(255) UNIQUE,
  `logo` VARCHAR(255),
  `whatsapp_number` VARCHAR(50),
  `whatsapp_format` TEXT,
  `plan_id` INT,
  `plan_start` DATE,
  `plan_end` DATE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Table structure for subscription_plans
-- ----------------------------
CREATE TABLE `subscription_plans` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(255) NOT NULL,
  `duration_days` INT NOT NULL,
  `max_users` INT NOT NULL,
  `price` DECIMAL(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Table structure for users
-- ----------------------------
CREATE TABLE `users` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `company_id` INT,
  `username` VARCHAR(100) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `role` ENUM('admin','user','global_admin') NOT NULL DEFAULT 'user',
  FOREIGN KEY (`company_id`) REFERENCES `companies`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Table structure for customers (Cariler)
-- ----------------------------
CREATE TABLE `customers` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `company_id` INT,
  `name` VARCHAR(255) NOT NULL,
  `phone` VARCHAR(50),
  FOREIGN KEY (`company_id`) REFERENCES `companies`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Table structure for products (Stok)
-- ----------------------------
CREATE TABLE `products` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `company_id` INT,
  `name` VARCHAR(255) NOT NULL,
  `price` DECIMAL(10,2) NOT NULL,
  FOREIGN KEY (`company_id`) REFERENCES `companies`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Table structure for orders
-- ----------------------------
CREATE TABLE `orders` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `company_id` INT,
  `user_id` INT,
  `customer_id` INT,
  `product_id` INT,
  `quantity` INT NOT NULL,
  `created_at` DATETIME NOT NULL,
  FOREIGN KEY (`company_id`) REFERENCES `companies`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`customer_id`) REFERENCES `customers`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`product_id`) REFERENCES `products`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Table structure for index_content
-- ----------------------------
CREATE TABLE `index_content` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(255),
  `subtitle` VARCHAR(255),
  `features` TEXT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Example Data
-- ----------------------------
INSERT INTO `subscription_plans` (`name`, `duration_days`, `max_users`, `price`) VALUES
('5 Kullanıcı / 1 Ay', 30, 5, 100.00),
('10 Kullanıcı / 3 Ay', 90, 10, 250.00),
('20 Kullanıcı / 6 Ay', 180, 20, 450.00);

INSERT INTO `companies` (`name`, `slug`, `plan_id`) VALUES
('Firma A', 'firma-a', 1),
('Firma B', 'firma-b', 2);

INSERT INTO `users` (`company_id`, `username`, `password`, `role`) VALUES
(1, 'admin_firmaA', '$2y$10$EXAMPLEHASH', 'admin'),
(2, 'admin_firmaB', '$2y$10$EXAMPLEHASH', 'admin'),
(NULL, 'globaladmin', '$2y$10$EXAMPLEHASH', 'global_admin');

INSERT INTO `index_content` (`title`, `subtitle`, `features`) VALUES
('Sipariş Takip Sistemi', 'Kağıt kalemi unutun, dijital sipariş alın!', 'Hızlı sipariş\nWhatsApp entegrasyonu\nPerformans takibi');
