MockTest Website - Ready to run (minimal)

1) Import SQL:
   - Open phpMyAdmin or MySQL and run sql/mocktest.sql to create database and tables.

2) Create an admin user (example):
   - Insert a user into users with is_admin=1. You can create via register.php and then set is_admin=1 via SQL, e.g.:
     UPDATE users SET is_admin=1 WHERE email='youradmin@example.com';

3) Copy files to XAMPP htdocs (or your server root).
   - /mnt/data/mocktest-website/*

4) Visit:
   - http://localhost/mocktest-website/index.php

Notes:
- This is a minimal, educational demo. For production, add input validation, CSRF protection, and secure session handling.
