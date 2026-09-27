# Eli Catering — Restaurant Menu Website

A Persian/RTL restaurant menu website for Eli Catering, built with Laravel 13 and designed to let the restaurant owner manage products and daily menus without developer assistance.

## Features

* Persian/RTL responsive public menu
* Admin authentication with role-based access control
* Admin dashboard
* Product CRUD
* Product activation/deactivation
* Product availability toggle
* Daily menu management
* Add/remove products from menus
* Per-item menu reordering
* Activate a menu for public display
* Admin password change
* Product image upload, resizing, and JPEG compression
* Custom 403, 404, and 500 error pages
* Security-related HTTP response headers
* Login rate limiting
* `robots.txt` and sitemap
* Automated feature tests for core menu, product, and admin functionality

## Tech Stack

* PHP 8.3+
* Laravel 13
* MySQL
* Blade
* Vite
* JavaScript
* CSS
* PHP GD extension

The application has been developed and tested locally with PHP 8.5.10. Its Composer dependencies are compatible with PHP 8.4.1+.

## Project Structure

```text
app/
├── Console/Commands/
│   └── CreateAdminUser.php
├── Http/
│   ├── Controllers/
│   │   ├── Admin/
│   │   └── MenuController.php
│   ├── Middleware/
│   └── Requests/
├── Models/
└── helpers.php

config/
└── restaurant.php

database/
├── migrations/
├── factories/
└── seeders/

resources/
├── css/
├── js/
└── views/

routes/
└── web.php

tests/
└── Feature/
```

## Installation

Clone the repository and install the PHP dependencies:

```bash
composer install
```

Install the front-end dependencies:

```bash
npm install
```

Create the environment file:

```bash
cp .env.example .env
```

Generate the application key:

```bash
php artisan key:generate
```

Configure the database credentials in `.env`, then run the migrations:

```bash
php artisan migrate
```

Create the public storage link:

```bash
php artisan storage:link
```

Build the front-end assets:

```bash
npm run build
```

Start the local development server:

```bash
php artisan serve
```

The application will then be available at:

```text
http://localhost:8000
```

## Admin Access

For local development, the database seeder provides a development admin account:

```text
Email: owner@elicatering.test
Password: change-me-immediately
```

This account is intended for development/testing only.

For a real owner account, create a separate administrator:

```bash
php artisan admin:create --name="Owner Name" --email="owner@example.com"
```

You can omit the password argument to enter it interactively rather than storing it in shell history.

The admin panel is available at:

```text
/admin/login
```

After deployment, the owner can manage products, prices, photos, availability, and daily menus directly through the admin panel without accessing the database or application code.

## Restaurant Configuration

Restaurant-specific information is centralized in:

```text
config/restaurant.php
```

Values such as the following are provided through environment variables:

* Restaurant name
* Phone number
* WhatsApp number
* Instagram handle
* Address
* Ordering hours

This keeps restaurant-specific information separate from the application logic and Blade templates.

## Image Handling

Product images are processed before being stored.

The application:

* Resizes images to a maximum of 1200px on the long side
* Converts uploaded images to JPEG
* Compresses them at approximately 82% quality
* Stores them on Laravel's public filesystem

Image processing uses PHP's GD extension.

## Testing

The project includes automated feature tests covering the core application logic.

Run the test suite with:

```bash
php artisan test
```

The tests cover areas including:

* Public menu visibility
* Active menu and active product logic
* Product creation
* Product deactivation and restoration
* Product availability
* Menu creation and management
* Menu item removal
* Menu item ordering
* Menu activation
* Admin access control

The test suite uses an in-memory SQLite database and does not modify the application's MySQL data.

In addition to automated tests, the application has been manually verified through the local browser, including:

* Public menu rendering
* Admin login
* Product management
* Menu activation/deactivation
* Product availability states
* Image upload and display
* Responsive mobile layout
* Mobile image loading
* Navigation and public/admin links

## Security

The application includes several basic security measures:

* Admin-only middleware for protected routes
* Login rate limiting
* Password hashing through Laravel's authentication system
* `X-Frame-Options`
* `X-Content-Type-Options`
* `Referrer-Policy`
* HTTPS enforcement in production
* Server-side request validation
* Uploaded image re-encoding

Secrets and environment-specific configuration are kept outside version control through `.gitignore`.

## Database Design

The main application entities are:

```text
users
products
menus
menu_items
```

Products use separate states for:

* `is_active` — whether the product is available in the admin system
* `is_available` — whether the product is currently available to customers

Products are deactivated rather than permanently deleted, allowing them to be restored without losing their historical references.

## Production Deployment

For production deployment:

1. Configure a production `.env` file.
2. Set:

```text
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.example
```

3. Configure the production MySQL database.
4. Ensure PHP has the required extensions, including GD.
5. Install dependencies without development packages:

```bash
composer install --no-dev --optimize-autoloader
```

6. Build the front-end assets:

```bash
npm run build
```

7. Run database migrations:

```bash
php artisan migrate --force
```

8. Create the public storage link:

```bash
php artisan storage:link
```

9. Cache the application configuration and routes/views as appropriate for the hosting environment.

The web server's document root should point to Laravel's `public/` directory.

## Current Scope

This is the first version of the Eli Catering website.

The current scope focuses on:

* Public daily menu presentation
* Product management
* Daily menu management
* Basic administrator access
* Responsive presentation
* Image optimization

Features such as password recovery by email, advanced historical menu browsing, online ordering, payment processing, and external object storage are outside the current scope.

## Known Limitations

* There is no email-based password recovery flow.
* Product images are stored on the local filesystem.
* There is no dedicated historical menu browsing interface.
* Automated tests do not currently cover the complete image upload/resize workflow or login throttling behavior.

These are known scope limitations rather than hidden functionality gaps.

## License

This project is a portfolio and client-oriented application developed for Eli Catering.
