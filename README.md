# API Platform (Laravel + DDEV)

This is a backend API platform built with **Laravel 12**, containerized using **DDEV (Docker)**.  
The platform provides:
- API rate limiting based on subscription tiers (Free, Standard, Premium)
- API usage tracking and reporting
- Monthly billing for premium users
- Admin utilities for subscription management

---

## Features
- **User Authentication:** Laravel Sanctum for token-based API access
- **Subscription Tiers:** Free, Standard, Premium
- **Rate Limiting:** Per-user API call limits based on subscription tier  
- **Usage Tracking:** Daily + monthly usage records  
- **Billing:** Monthly usage-based billing for premium users
- **Admin:** Manage user subscriptions (admin routes)

---

## Setup Instructions (DDEV)

### 1️ Clone the repo
```bash
git clone git@github.com:itsrahulrs/api-platform.git
cd api-platform
```

### 2 Start DDEV
```bash
ddev start
```

### 3️ Install dependencies
```bash
ddev composer install
```

### 4 Set up environment
```bash
cp .env.example .env
ddev php artisan key:generate
```

### 5 Run migrations + seeders
```bash
ddev php artisan migrate --seed
```

### Monthly billing logic is handled by an Artisan command (testing)
```bash
ddev php artisan billing:generate
```

## DDEV / Docker Notes

- All services (Laravel, MySQL) run inside DDEV containers
- DB host = db | DB port = 3306

#### Common commands:
```bash
ddev php artisan migrate
ddev php artisan db:seed
ddev php artisan schedule:run
ddev php artisan queue:work
ddev composer install
ddev artisan serve
```

## Accessing the app

- Your Laravel app will be available at:
```bash
https://api-platform.ddev.site
```