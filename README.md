<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

E-Commerce Project
Overview
This is a simple e-commerce project built using a REST API. Users can sign up, sign in, view products, add them to the cart, create orders, and receive notifications when a new order is created.

Table of Contents
Installation
Usage
Database
API Endpoints
Cart Operations
Order Operations
Admin Dashboard
Notification System
License
Installation
Clone the repository:
bash
Copy code
git clone https://github.com/your-username/e-commerce.git
cd e-commerce
Install dependencies:
bash
Copy code
composer install
npm install
Set up the database:
bash
Copy code
php artisan migrate --seed
Generate application key:
bash
Copy code
php artisan key:generate
Usage
User Authentication
Users can sign up and sign in to the system using their email and password.
Product Listing
Products can be viewed by accessing the relevant endpoints.
Cart Operations
Users can add products to the cart, delete items, increment, and decrement quantities.
Order Operations
Users can create orders.
Admin Dashboard
Admins can log in to the dashboard to view notifications and manage orders.
Notification System
The system sends notifications to admins when a new order is created using native Socket.IO or Laravel Echo.
Database
User Table
Fields: Name, Email, Phone, Password
Product Table
Fields: Name, Quantity, Image
Seeder
Seeder data is provided for users and products.
API Endpoints
List and documentation of all API endpoints.
Cart Operations
Detailed explanation of cart operations.
Order Operations
Detailed explanation of order operations.
Admin Dashboard
Instructions for admin login and dashboard usage.
Notification System
Explanation of the notification system and how to set up Socket.IO or Laravel Echo.
