USE petshop;

INSERT INTO products (name, price, image, description) VALUES
('Premium Dog Food', 899.00, 'pixabay/paw-product-dog-food.jpg', 'Nutritious, protein-rich dog food for active pets.'),
('Cat Feather Toy', 299.00, 'pixabay/paw-product-cat-toy.jpg', 'Interactive feather toy to keep cats engaged and happy.'),
('Reflective Dog Leash', 499.00, 'pixabay/paw-product-leash.jpg', 'Durable leash with reflective stitching for safe walks.'),
('Cozy Dog Bed', 1299.00, 'pixabay/paw-product-dog-bed.jpg', 'Soft, supportive bed for restful sleep.'),
('Plush Cat Bed', 999.00, 'pixabay/paw-product-cat-bed.jpg', 'Warm and comfy bed for cats of all sizes.'),
('Healthy Cat Treats', 349.00, 'pixabay/paw-product-cat-treats.jpg', 'Tasty treats with vitamins for shiny coats.');

-- Default admin account: admin@pawmart.com / admin123
INSERT INTO admin (username, email, password)
VALUES ('admin', 'admin@pawmart.com', '$2y$12$Brjx88eslHb7bydctiOqDeLErIZgvRWUVJ/gUBB4MJWSoQfJV.Ro.');
