# Sham Ads

منصة إعلانية رقمية مبنية باستخدام **Laravel** لإدارة الحملات الإعلانية، الإعلانات، الناشرين، مناطق العرض، التتبع والتحليلات، مع نظام محافظ مالية ومعالجة العمليات.

## 🚀 نبذة عن المشروع

**Sham Ads** هو نظام إدارة إعلانات يربط بين:

* المعلنين (Advertisers)
* الناشرين (Publishers)
* الحملات الإعلانية (Campaigns)
* مناطق عرض الإعلانات (Ad Zones)
* تتبع الظهور والنقرات (Impressions & Clicks)
* التحليلات والإحصائيات
* نظام المحافظ والمعاملات المالية

الهدف من المشروع هو توفير بنية إعلانية قابلة للتوسع تدعم إدارة دورة الإعلان كاملة من الإنشاء حتى العرض والتحليل.

---

# ✨ الميزات الرئيسية

## إدارة المستخدمين

يدعم النظام أدوار متعددة:

* Administrator
* Advertiser
* Publisher

مع صلاحيات مختلفة حسب نوع المستخدم.

---

## إدارة الحملات الإعلانية

تشمل:

* إنشاء الحملات
* مراجعة واعتماد الحملات
* تحديد الميزانية
* تحديد فترة التشغيل
* حساب الميزانية المتبقية
* التحكم في حالة الحملة

حالات الحملة:

```
pending
approved
rejected
```

---

## إدارة الإعلانات

يدعم:

* إنشاء الإعلانات
* أنواع المحتوى المختلفة
* ربط الإعلان بالحملة
* ربط الإعلان بمناطق العرض
* معاينة الإعلان
* متابعة حالة الإعلان

حالات الإعلان:

```
draft
pending_review
active
paused
rejected
```

---

## الناشرون ومناطق العرض

يدعم:

* إنشاء Ad Zones
* ربط المناطق بالناشرين
* عرض الإعلانات المناسبة
* متابعة الأداء لكل منطقة

---

## التتبع والتحليلات

النظام يحتوي على:

* Impressions Tracking
* Click Tracking
* Ad Events
* Fraud Detection Structure
* Analytics Controllers

مع إمكانية تطوير نظام كشف الاحتيال بشكل مستقل.

---

## النظام المالي

يتضمن:

* Wallet System
* Wallet Transactions
* Ledger Tracking
* حساب الرصيد تلقائيًا
* دعم عمليات Credit / Debit

---

# 🛠️ التقنيات المستخدمة

## Backend

* PHP 8+
* Laravel Framework
* Eloquent ORM
* Laravel Authentication

## Database

* MySQL / MariaDB
* SQLite للتطوير المحلي

## Frontend

* Blade Templates
* Laravel Views
* CSS / JavaScript

---

# 📂 هيكل المشروع

```
app/
 ├── Http/
 │   └── Controllers/
 │
 └── Models/
     ├── Ad.php
     ├── Campaign.php
     ├── Click.php
     ├── Wallet.php
     └── User.php


database/
 ├── migrations/
 └── seeders/


resources/
 └── views/


routes/
 ├── web.php
 ├── advertiser.php
 └── publisher.php
```

---

# ⚙️ التثبيت والتشغيل

## 1. تحميل المشروع

```bash
git clone https://github.com/Masterwebhosts/Sham-Ads.git

cd Sham-Ads
```

---

## 2. تثبيت الحزم

```bash
composer install
```

---

## 3. إعداد ملف البيئة

انسخ ملف البيئة:

```bash
cp .env.example .env
```

ثم عدل إعدادات قاعدة البيانات داخل:

```
.env
```

---

## 4. إنشاء مفتاح التطبيق

```bash
php artisan key:generate
```

---

## 5. تشغيل Migration

```bash
php artisan migrate
```

---

## 6. تشغيل الخادم

```bash
php artisan serve
```

المشروع يعمل على:

```
http://127.0.0.1:8000
```

---

# 🧪 أوامر التطوير المفيدة

تنظيف الكاش:

```bash
php artisan optimize:clear
```

عرض المسارات:

```bash
php artisan route:list
```

حالة قاعدة البيانات:

```bash
php artisan migrate:status
```

---

# 🔒 ملاحظات أمنية

لا يتم رفع الملفات التالية إلى GitHub:

```
.env
vendor/
node_modules/
storage/logs/
bootstrap/cache/
database/*.sqlite
```

---

# 🗺️ خارطة التطوير المستقبلية

* [ ] نظام دفع إلكتروني
* [ ] نظام تقارير متقدم
* [ ] تحسين Fraud Detection
* [ ] API للمعلنين والناشرين
* [ ] نظام مزادات إعلانية Real-Time Bidding
* [ ] تحسين Dashboard UI

---

# 👨‍💻 المطور

**Sham Ads Team**

Laravel Advertisement Platform

---

# 📄 License

هذا المشروع للاستخدام والتطوير الداخلي.
