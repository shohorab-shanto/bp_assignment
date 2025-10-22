<pre>
# My Laravel Project

A Laravel web application for a simple e-commerce platform with categories, subcategories, and products.

---

## Features

- Category → Product → Subcategory relationship
- Product CRUD operations
- Image upload support
- Responsive UI
- Ready for production deployment

---

## Requirements

- PHP >= 8.0
- Composer
- MySQL 

---

## Installation (Local)

1. Clone the repository:
   git clone &lt;https://github.com/shohorab-shanto/bp_assignment.git

2. Copy .env.example to .env and configure:
   cp .env.example .env
   php artisan key:generate

3. Run migrations:
   php artisan migrate

4. (Optional) Link storage:
   php artisan storage:link

5. Serve locally:
   php artisan serve

---

## Database Schema

| Table | Relationships |
|-------|---------------|
| categories | hasMany subcategories, hasMany products |
| subcategories | belongsTo category, hasMany products |
| products | belongsTo category, belongsTo subcategory |

---

## Notes

- Never commit .env to GitHub — use .env.example for reference.
- Run php artisan migrate --force during deployment to avoid confirmation prompts.
- Storage directory must be writable (storage/ and bootstrap/cache/).

---

## Useful Commands

php artisan key:generate
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan migrate --force
php artisan serve

---

## Author

Your Name  
Email: shohorabshanto@gmail.com 
GitHub: https://github.com/shohorab-shanto
</pre>
