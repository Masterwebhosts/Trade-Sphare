# TradeSphare

### Advertising & Monetization Platform

**TradeSphare** is a full-stack **AdTech platform** designed to manage advertising campaigns, advertisements, publishers, ad zones, tracking, analytics, wallets, and monetization.

The platform provides an end-to-end advertising workflow connecting **advertisers, publishers, campaigns, advertisements, and audiences** through a centralized management system.

> **Project Status:** Private / Development Project

---

## 🚀 Overview

TradeSphare was designed and developed from the ground up as a scalable advertising and monetization platform.

The platform covers the core advertising lifecycle:

```text
Advertiser
    ↓
Campaign
    ↓
Advertisement
    ↓
Ad Selection
    ↓
Publisher
    ↓
Ad Zone
    ↓
Impression / Click
    ↓
Analytics
    ↓
Wallet / Ledger
    ↓
Monetization
```

The architecture separates advertising management, ad serving, tracking, analytics, fraud detection, and financial operations into dedicated components.

---

## ✨ Core Features

### 👥 User & Role Management

TradeSphare supports multiple user roles with role-based access control:

* Administrator
* Advertiser
* Publisher

Each role has dedicated workflows and permissions.

---

### 📢 Campaign Management

Advertisers can manage campaigns throughout their lifecycle.

Features include:

* Campaign creation
* Campaign approval workflow
* Budget management
* Campaign scheduling
* Targeting
* Budget availability checks
* Campaign status management

Supported campaign states include:

```text
pending
approved
rejected
```

---

### 🖼️ Advertisement Management

The platform supports:

* Advertisement creation
* Multiple advertisement content types
* Campaign association
* Ad Zone association
* Advertisement preview
* Advertisement activation and management
* Advertisement status control

Supported advertisement states include:

```text
draft
pending_review
active
paused
rejected
```

---

### 🌐 Publishers & Ad Zones

Publishers can create and manage advertising inventory through dedicated Ad Zones.

Features include:

* Ad Zone creation
* Publisher association
* Zone tokens
* Advertisement serving
* Zone performance tracking
* Zone analytics

Each Ad Zone provides the context required to determine which advertisements can be served.

---

## 🎯 Ad Serving

TradeSphare includes a dedicated advertisement selection and serving layer.

The system can:

* Resolve an Ad Zone using its token
* Validate the zone status
* Determine eligible advertisements
* Validate campaign availability
* Validate advertisement availability
* Apply targeting rules
* Select an appropriate advertisement
* Return advertisement data through an API

The architecture also supports caching to improve advertisement selection performance.

---

## 📊 Tracking & Analytics

TradeSphare provides event tracking for measuring advertising performance.

Tracked events include:

* Impressions
* Clicks
* Advertisement events
* Publisher activity
* Campaign performance
* Ad Zone performance

The tracking layer validates the advertisement, zone, and publisher context before recording events.

---

## 🛡️ Fraud Detection

The platform includes a dedicated fraud-scoring foundation for identifying suspicious advertising activity.

The current approach can evaluate signals such as:

* Click frequency
* IP-based behavior
* User-Agent analysis
* Automated traffic indicators
* Burst behavior
* Suspicious request patterns

Fraud decisions can be classified into:

```text
allow
review
block
```

The fraud-detection architecture is designed to be extended with more advanced behavioral analysis and fingerprinting.

---

## 🚦 Rate Limiting

Tracking endpoints are protected with rate limiting to help reduce abusive traffic and excessive tracking requests.

The tracking layer uses a dedicated rate limiter for controlling request frequency.

---

## 💰 Wallet & Financial System

TradeSphare includes a financial layer for managing advertiser and publisher balances.

Core components include:

* Wallets
* Wallet transactions
* Credit / Debit operations
* Ledger entries
* Balance tracking
* Withdrawal requests
* Financial transaction history

The financial architecture is designed around an auditable ledger approach.

---

## 📒 Ledger Architecture

Financial writes are handled through a dedicated ledger service.

The ledger layer is responsible for:

* Recording financial operations
* Validating transaction direction
* Maintaining transaction consistency
* Linking transactions to their source
* Preventing duplicate financial operations
* Processing financial operations inside database transactions

The architecture is designed to provide a reliable source of truth for monetary operations.

---

## 💳 Advertising Monetization

The platform supports advertising monetization workflows between advertisers, publishers, and the platform.

A click-based transaction can be processed through the financial layer and distributed between the relevant parties according to the platform's monetization rules.

The system also includes safeguards against duplicate charging for the same advertising event.

---

## 📈 Analytics

Dedicated dashboards and analytics components provide visibility into:

* Campaign performance
* Advertisement performance
* Impressions
* Clicks
* Publisher activity
* Ad Zone performance
* Financial activity

The platform uses charting and aggregated data to provide a clearer view of advertising performance.

---

## 🔌 API

TradeSphare provides API endpoints for advertisement serving and tracking.

### Serve Advertisement

```http
GET /api/zones/{token}/serve
```

### Track Impression

```http
POST /api/track/impression
```

### Track Click

```http
POST /api/track/click
```

These endpoints provide the foundation for integrating TradeSphare with external websites and applications.

---

## 🧩 Architecture

The application is structured around Laravel's MVC architecture with dedicated service layers for complex business logic.

Major components include:

```text
Authentication
        ↓
Role & Permission Management
        ↓
Campaign Management
        ↓
Advertisement Management
        ↓
Ad Serving
        ↓
Tracking
        ↓
Analytics
        ↓
Fraud Detection
        ↓
Wallet / Ledger
        ↓
Monetization
```

Dedicated services handle specialized responsibilities such as:

```text
Ad Selection
Tracking
Fraud Scoring
Financial Ledger
```

This separation helps keep business logic maintainable and easier to extend.

---

## 🛠️ Technology Stack

### Backend

* PHP 8.2+
* Laravel 12
* Eloquent ORM
* Laravel Authentication
* REST API

### Frontend

* Blade
* Tailwind CSS
* Alpine.js
* JavaScript
* Vite
* ApexCharts

### Database

* MySQL / MariaDB
* SQLite for local development

### Development

* Composer
* NPM
* PHPUnit
* Laravel Pint
* Git
* GitHub

---

## 📂 Project Structure

```text
app/
├── Http/
│   ├── Controllers/
│   └── Middleware/
│
├── Models/
│   ├── User.php
│   ├── Campaign.php
│   ├── Ad.php
│   ├── AdZone.php
│   ├── Click.php
│   ├── Impression.php
│   └── Wallet.php
│
└── Services/
    ├── AdSelection/
    ├── Tracking/
    ├── Fraud/
    └── Ledger/

database/
├── migrations/
└── seeders/

resources/
└── views/

routes/
├── web.php
├── api.php
├── advertiser.php
└── publisher.php

tests/
```

---

## ⚙️ Installation

### 1. Clone the repository

```bash
git clone https://github.com/Masterwebhosts/Trade-Sphare.git
cd Trade-Sphare
```

### 2. Install PHP dependencies

```bash
composer install
```

### 3. Configure environment

Copy the example environment file:

```bash
cp .env.example .env
```

On Windows PowerShell:

```powershell
Copy-Item .env.example .env
```

Configure the application and database settings inside:

```text
.env
```

### 4. Generate application key

```bash
php artisan key:generate
```

### 5. Run database migrations

```bash
php artisan migrate
```

### 6. Install frontend dependencies

```bash
npm install
```

### 7. Build frontend assets

```bash
npm run build
```

### 8. Start the Laravel development server

```bash
php artisan serve
```

The application will be available at:

```text
http://127.0.0.1:8000
```

---

## 🧪 Development Commands

Clear Laravel caches:

```bash
php artisan optimize:clear
```

List application routes:

```bash
php artisan route:list
```

Check migration status:

```bash
php artisan migrate:status
```

Run automated tests:

```bash
php artisan test
```

Format Laravel code:

```bash
./vendor/bin/pint
```

Run Vite development server:

```bash
npm run dev
```

---

## 🔐 Security & Environment

Sensitive configuration must never be committed to GitHub.

The following should remain outside version control:

```text
.env
/vendor
/node_modules
/storage/logs
/bootstrap/cache
/database/*.sqlite
```

Production credentials, API keys, database credentials, and private configuration values must remain protected.

---

## 🗺️ Future Development

Potential future improvements include:

* [ ] Advanced fraud detection
* [ ] Device fingerprinting
* [ ] Advanced reporting
* [ ] Public Advertiser API
* [ ] Public Publisher API
* [ ] Online payment integrations
* [ ] Real-Time Bidding (RTB)
* [ ] Advanced campaign targeting
* [ ] Improved analytics dashboards
* [ ] Expanded automated test coverage
* [ ] Performance optimization
* [ ] CI/CD pipeline
* [ ] Production monitoring and observability

---

## 🌍 Live Platform

TradeSphare is available online:

**https://tradesphare.com/**

The platform website provides an overview of the advertising and monetization system.

---

## 👨‍💻 Founder & Developer

### Yassin Sheikh Hassan

**Founder & Full-Stack Developer**

TradeSphare was conceived, designed, and developed from the ground up by **Yassin Sheikh Hassan**, including the product concept, application architecture, backend logic, database design, APIs, advertising workflows, tracking system, financial components, and platform integration.

### Areas of Focus

* Full-Stack Web Development
* PHP & Laravel
* MySQL
* REST APIs
* SaaS Architecture
* AdTech Platforms
* Tracking & Analytics
* Financial Systems
* Web Application Architecture

---

## 📌 Project Status

**TradeSphare is a private development project.**

The repository is maintained as part of the ongoing development and technical portfolio of its founder.

The platform continues to evolve with improvements to security, scalability, analytics, testing, monetization, and production readiness.

---

## 📄 License

This project is proprietary and intended for private development and portfolio purposes.

Unauthorized redistribution, commercial use, or reproduction of the source code is not permitted without permission from the project owner.
