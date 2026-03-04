-- ===================================


-- ===================================
-- GAMECLOUD - Cloud Gaming Website
-- SQL Database Setup Queries
-- ===================================

-- Create Database
CREATE DATABASE IF NOT EXISTS cloud_gaming;
USE cloud_gaming;

-- ===================================
-- TABLE 1: USERS (Players)
-- ===================================
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- ===================================
-- TABLE 2: PRODUCTS (Games)
-- ===================================
CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    image VARCHAR(255),
    description LONGTEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- ===================================
-- TABLE 3: CART (Subscription Cart)
-- ===================================
CREATE TABLE IF NOT EXISTS cart (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    product_id INT NOT NULL,
    qty INT DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

-- ===================================
-- TABLE 4: ORDERS (Subscriptions)
-- ===================================
CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    total DECIMAL(10, 2) NOT NULL,
    payment_status VARCHAR(50) DEFAULT 'Pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- ===================================
-- TABLE 4B: ORDER_ITEMS (Games in Each Subscription/Order)
-- ===================================
CREATE TABLE IF NOT EXISTS order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    qty INT DEFAULT 1,
    price DECIMAL(10,2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

-- ===================================
-- TABLE 5: WISHLIST (Favorites)
-- ===================================
CREATE TABLE IF NOT EXISTS wishlist (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    product_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    UNIQUE KEY unique_wishlist (user_id, product_id)
);

-- ===================================
-- TABLE 6: ADMIN (Admin Users)
-- ===================================
CREATE TABLE IF NOT EXISTS admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- ===================================
-- SAMPLE DATA - GAMES (Products)
-- ===================================
INSERT INTO products (name, price, image, description) VALUES
('Elden Ring', 99.99, 'elden_ring.jpg', 'Rise, Tarnished, and let grace guide you in a new land of adventure. A magnificent view of the world spreads before you.'),
('Cyberpunk 2077', 89.99, 'cyberpunk.jpg', 'An open-world action RPG set in the sprawling, neon-lit Night City. Play as V, an outlaw going on the greatest job ever.'),
('The Witcher 3', 79.99, 'witcher3.jpg', 'As a witcher, you take contracts to slay dangerous monsters and earn coin. Discover an open world full of meaningful characters and quests.'),
('Starfield', 99.99, 'starfield.jpg', 'Explore infinite procedurally generated star systems, planets, and moons. Become the spacefarer you always dreamed of.'),
('Hogwarts Legacy', 89.99, 'hogwarts.jpg', 'Embark on a dark wizarding world and discover what it takes to become a powerful wizard. Uncover secrets and unlock new magic.'),
('Baldur\'s Gate 3', 99.99, 'baldurs_gate.jpg', 'Gather your party and venture into the Forgotten Realms in a tale of fellowship and betrayal, glory and ruin.'),
('Final Fantasy XVI', 99.99, 'ff16.jpg', 'The world has fallen under the dominion of the Midgardsormr, the eikon of darkness. Join Clive on an unforgettable journey.'),
('Palworld', 29.99, 'palworld.jpg', 'Catch and command Pals to fight, farm, build, and work in co-op multiplayer adventures across a beautiful world.'),
('Dragon\'s Dogma 2', 69.99, 'dragons_dogma.jpg', 'Venture forth as the Arisen and uncover the endless mystery behind the dragon Daimon. A world of adventure awaits you.'),
('Street Fighter 6', 59.99, 'sf6.jpg', 'Master the art of combat with all-new gameplay mechanics and an incredible roster of World Warriors across three modes.');

-- ===================================
-- SAMPLE DATA - USERS
-- ===================================
-- Use INSERT IGNORE to avoid duplicate entry errors if users already exist
INSERT IGNORE INTO users (name, email, password) VALUES
('John Doe', 'john@example.com', '$2y$10$abcdefghijklmnopqrstuvwxyz1234567890'),
('Jane Smith', 'jane@example.com', '$2y$10$abcdefghijklmnopqrstuvwxyz1234567890'),
('Mike Johnson', 'mike@example.com', '$2y$10$abcdefghijklmnopqrstuvwxyz1234567890');

-- ===================================
-- Use INSERT IGNORE to avoid duplicate entry errors for admin
INSERT IGNORE INTO admin (username, email, password) VALUES
('admin', 'admin@gamecloud.com', '$2y$10$abcdefghijklmnopqrstuvwxyz1234567890');

-- ===================================
-- CREATE INDEXES FOR PERFORMANCE
-- ===================================
-- Only create indexes if they do not already exist
-- Note: MySQL does not support 'IF NOT EXISTS' for CREATE INDEX, so check for existence first or use unique/primary keys
-- The 'email' field in 'users' is already UNIQUE, so a separate index is not needed
-- Remove duplicate/pointless index creation

-- CREATE INDEX idx_cart_user ON cart(user_id);
-- CREATE INDEX idx_cart_product ON cart(product_id);
-- CREATE INDEX idx_orders_user ON orders(user_id);
-- CREATE INDEX idx_wishlist_user ON wishlist(user_id);
-- CREATE INDEX idx_wishlist_product ON wishlist(product_id);
-- CREATE INDEX idx_admin_email ON admin(email);

-- ===================================
-- QUERIES FOR COMMON OPERATIONS
-- ===================================

-- Get all games
-- SELECT * FROM products;

-- Get specific game
-- SELECT * FROM products WHERE id = 1;

-- Get user by email
-- SELECT * FROM users WHERE email = 'user@example.com';

-- Get user's cart
-- SELECT c.id, p.name, p.price, c.qty FROM cart c
-- JOIN products p ON c.product_id = p.id
-- WHERE c.user_id = 1;


-- For direct SQL testing, replace ? with a user id (e.g., 1)
SELECT DISTINCT p.*
FROM orders o
JOIN order_items oi ON o.id = oi.order_id
JOIN products p ON oi.product_id = p.id
WHERE o.user_id = 1
ORDER BY o.created_at DESC
LIMIT 25;
-- For PHP prepared statements, use WHERE o.user_id = ? and bind the parameter in your code.

-- Get user's favorite games
-- SELECT p.id, p.name, p.price FROM wishlist w
-- JOIN products p ON w.product_id = p.id
-- WHERE w.user_id = 1;

-- Get dashboard statistics
-- SELECT COUNT(*) FROM products;
-- SELECT COUNT(*) FROM users;
-- SELECT COUNT(*) FROM orders;

-- Total revenue
-- SELECT SUM(total) FROM orders WHERE payment_status = 'Card Payment Confirmed';



-- ===================================
-- SUBSCRIPTIONS & CART LOGIC QUERIES
-- ===================================


-- For direct SQL testing, replace ? with values. For PHP, use parameter binding.
INSERT INTO cart (user_id, product_id, qty)
SELECT 1, 2, 1 FROM DUAL
WHERE NOT EXISTS (SELECT 1 FROM cart WHERE user_id = 1 AND product_id = 2);

UPDATE cart SET qty = qty + 1 WHERE user_id = 1 AND product_id = 2;

-- On checkout: create order and move cart items to order_items
-- 1. Insert into orders (user_id, total, ...)
-- 2. For each cart item, insert into order_items (order_id, product_id, qty, price)
-- 3. Delete cart items for user

-- Get all games in a user's cart (for cart.php)
-- For direct SQL testing, replace ? with a user id (e.g., 1)
SELECT c.id AS cart_id, p.name, p.price, p.image, c.qty
FROM cart c
JOIN products p ON c.product_id = p.id
WHERE c.user_id = 1
LIMIT 25;
-- For PHP prepared statements, use WHERE c.user_id = ? and bind the parameter in your code.

-- ...existing code...
