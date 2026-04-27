# 🚀 Bulk Student Notification System

A modern **Admin Panel-based Notification System** built with Laravel that enables administrators to send **bulk emails & SMS**, manage templates, and track delivery performance with ease.

---

## 🌟 Key Features

### 🔐 Authentication

* Secure Admin Login System
* OTP-based Password Reset
* Session-based authentication

### 📩 Notification System

* Send Bulk Emails to students
* Send Bulk SMS (Twilio Integration)
* Dynamic placeholders support:

  * `{name}`, `{email}`, `{course}`, `{roll_number}`

### 🧩 Template Management

* Create / Edit / Delete Templates
* Email & SMS template support
* Reusable message system

### 📊 Reporting & Tracking

* Total Emails & SMS sent
* Failed Notifications tracking
* Error message logging
* Delivery status (Sent / Failed / Pending)

### 📂 CSV Upload

* Upload student data via Excel/CSV
* Bulk data processing

### 👤 Admin Panel

* Dashboard with analytics
* Profile management
* Change password feature
* Clean & responsive UI

---

## 📸 Screenshots

> *(Add your screenshots inside a `/screenshots` folder)*

* Dashboard
* Bulk Notification Page
* Template Management
* Failed Notifications
* Admin Profile

---

## 🛠 Tech Stack

* **Backend:** Laravel 12 (PHP)
* **Frontend:** Blade, HTML, CSS, JavaScript
* **Database:** MySQL
* **Email:** SMTP (Gmail)
* **SMS:** Twilio API
* **Version Control:** Git & GitHub

---

## ⚙️ Installation

```bash
git clone https://github.com/kmramar/bulk-student-notifier.git
cd bulk-student-notifier

composer install
cp .env.example .env
php artisan key:generate
```

---

## 🔧 Environment Setup (.env)

```env
DB_DATABASE=bulk_notifier
DB_USERNAME=root
DB_PASSWORD=

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email
MAIL_PASSWORD=your-app-password
```

---

## 🗄 Database Setup

```bash
php artisan migrate
```

---

## ▶️ Run Project

```bash
php artisan serve
```

Open in browser:

```
http://127.0.0.1:8000
```

---

## 🚀 Future Improvements

* Retry Failed Notifications
* Queue system for bulk processing
* Real-time delivery tracking
* Role-based access control
* Live deployment (Render / VPS)

---

## 👨‍💻 Author

**Amar Kumar**

* GitHub: https://github.com/kmramar
* Email: [amarkumar.official09@gmail.com](mailto:amarkumar.official09@gmail.com)

---

## ⭐ Support

If you like this project, consider giving it a ⭐ on GitHub!

---
