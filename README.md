#  Bulk Student Notification System

A Laravel-based Admin Panel to manage students and send bulk notifications via Email and SMS.

---

##  Features

- 📥 CSV Upload (Bulk Student Import)
- 📧 Bulk Email Sending
- 📱 Bulk SMS Sending
- 📊 Admin Dashboard
- 📈 Reports & Analytics
- 🔁 Response Tracking
- 🛠 Full CRUD Operations

---

##  Tech Stack

- Laravel (PHP)
- MySQL
- Bootstrap 5
- JavaScript

---

##  Screenshots

(<img width="1440" height="811" alt="Screenshot 2026-04-14 at 2 47 58 AM" src="https://github.com/user-attachments/assets/96ac74a7-9d41-4679-862d-8e1075fb9504" />
)

---

##  Installation

```bash
git clone https://github.com/kmramar/bulk-student-notifier.git
cd bulk-student-notifier
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve
