👟 Shoes E-Commerce Backend (Laravel)

A powerful and scalable Shoes E-commerce Backend API built using Laravel.
This project provides RESTful APIs for managing products, categories, orders, users, authentication, and more.

🚀 Project Overview

This backend system is designed for a Shoes E-commerce Platform where customers can:

Browse shoes

Filter by categories

View product details

Add to cart

Place orders

Manage user accounts

Admins can:

Manage products

Manage categories

Control inventory

Manage orders

Handle user roles

🛠 Tech Stack

Framework: Laravel

Language: PHP

Database: MySQL

Authentication: Laravel Sanctum (API Token Based)

API Format: RESTful JSON

Frontend Support: Vite (Asset bundling)

📂 Project Structure
app/            → Core Application Logic (Models, Controllers, Services)
routes/         → API & Web Routes
database/       → Migrations & Seeders
config/         → Application Configuration
resources/      → Blade Views & Frontend Resources
public/         → Public Assets
tests/          → Application Tests

⚙️ Installation Guide

Follow these steps to run the project locally:

1️⃣ Clone the Repository
git clone https://github.com/kaifsherdi1/shoes_ecommerce_backend.git
cd shoes_ecommerce_backend

2️⃣ Install Dependencies
composer install
npm install

3️⃣ Setup Environment File
cp .env.example .env


Update database credentials inside .env:

DB_DATABASE=your_database_name
DB_USERNAME=your_username
DB_PASSWORD=your_password

4️⃣ Generate Application Key
php artisan key:generate

5️⃣ Run Migrations
php artisan migrate


(Optional: If seeders exist)

php artisan db:seed

6️⃣ Run the Server
php artisan serve


App will run at:

http://127.0.0.1:8000

🔐 Authentication

This project uses Laravel Sanctum for API authentication.

Register

Login

Receive Token

Access protected routes using Bearer Token

Example Header:

Authorization: Bearer YOUR_TOKEN_HERE

📦 Core Features
👤 User Management

User Registration

Login / Logout

Role-based Access (Admin / Customer)

👟 Product Management

Create Product

Update Product

Delete Product

Product Images

Price Management

🗂 Category Management

Create Category

Update Category

Delete Category

🛒 Order System

Add to Cart

Place Order

Order History

Order Status Management

📊 Admin Dashboard APIs

View total users

View total products

View sales data

Inventory management

🔄 API Example Endpoints
Method	Endpoint	Description
POST	/api/register	Register User
POST	/api/login	Login User
GET	/api/products	Get All Products
POST	/api/products	Create Product
GET	/api/categories	Get All Categories
POST	/api/orders	Place Order
🧪 Testing

Run tests using:

php artisan test

🧱 Future Improvements

Payment Gateway Integration (Stripe / Razorpay)

Wishlist Feature

Coupon System

Product Reviews & Ratings

Advanced Filtering (Size, Brand, Price Range)

Multi-vendor Support

👨‍💻 Author

Kaif Sherdi
GitHub: https://github.com/kaifsherdi1

📜 License

This project is open-source and available under the MIT License
