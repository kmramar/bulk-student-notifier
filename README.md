#  Bulk Student Notification System

A Laravel-based Admin Panel to manage students and send bulk notifications via Email and SMS.

---

##  Features

-  CSV Upload (Bulk Student Import)
-  Bulk Email Sending
-  Bulk SMS Sending
-  Admin Dashboard
-  Reports & Analytics
-  Response Tracking
-  Full CRUD Operations

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
<img width="1440" height="489" alt="Screenshot 2026-04-14 at 2 50 40 AM" src="https://github.com/user-attachments/assets/c721efa0-85d8-4544-9480-7dd823cc246f" />
<img width="1440" height="814" alt="Screenshot 2026-04-14 at 2 52 07 AM" src="https://github.com/user-attachments/assets/a6dbd5a1-9bb4-47e8-bad3-8546dacdb539" />
<img width="1440" height="814" alt="Screenshot 2026-04-14 at 2 52 35 AM" src="https://github.com/user-attachments/assets/68b08124-58f9-4b7f-81ee-59e532b5e867" />
<img width="1440" height="814" alt="Screenshot 2026-04-14 at 2 53 00 AM" src="https://github.com/user-attachments/assets/6f9413b5-c1f8-49a6-bde6-81515c77b329" />
<img width="1440" height="814" alt="Screenshot 2026-04-14 at 2 53 46 AM" src="https://github.com/user-attachments/assets/6663c8be-a54d-412e-80a0-c46eb7e09684" />
<img width="1440" height="814" alt="Screenshot 2026-04-14 at 2 54 16 AM" src="https://github.com/user-attachments/assets/b50f5c6d-55b1-4334-bf1a-0c45ad2f8a12" />
<img width="1440" height="814" alt="Screenshot 2026-04-14 at 2 54 52 AM" src="https://github.com/user-attachments/assets/ccc81b0b-4cef-4f15-a217-942d8bd87646" />
<img width="1440" height="814" alt="Screenshot 2026-04-14 at 2 55 25 AM" src="https://github.com/user-attachments/assets/233f3c62-553a-4020-8319-53bad597fb59" />
<img width="1440" height="814" alt="Screenshot 2026-04-14 at 2 55 52 AM" src="https://github.com/user-attachments/assets/f492d65a-d79b-4002-8593-7a549341a681" />
<img width="1440" height="814" alt="Screenshot 2026-04-14 at 2 56 10 AM" src="https://github.com/user-attachments/assets/78092e02-262c-4225-b967-6af231b3a4f1" />
<img width="1440" height="814" alt="Screenshot 2026-04-14 at 2 56 31 AM" src="https://github.com/user-attachments/assets/12918e84-b468-4155-b2a1-ebd7da87424b" />

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
