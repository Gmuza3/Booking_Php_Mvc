# 📋 Booking Management System (PHP & MySQL)

This is a full-stack booking management system developed using **pure PHP**, **MySQL**, and **Vanilla CSS**. It supports user registration, secure JWT-based authentication, booking services, and admin-level management via a dashboard.

---

## 🚀 Features

- ✅ User Registration & Login using **JWT**
- 🔐 Protected Routes via Middleware
- 📅 Book Services (with Date & Time)
- 🧾 Admin Dashboard (Manage All Bookings)
- 👥 Role-Based Access Control (User / Admin)
- 📁 Clean MVC Architecture
- 🖼️ Service Images
- ⚙️ Booking Status: Pending / Confirmed / Canceled
- 🛡️ Secure Tokens stored in HttpOnly Cookies
- 🌐 Responsive & Lightweight Frontend

---

## 🛠️ Technologies Used

- PHP 8+
- MySQL
- JWT (Custom Implementation)
- Composer (for Autoloading)
- DotEnv (for environment config)
- Vanilla JavaScript
- Vanilla CSS (can be styled with Bootstrap if desired)
- Bootstrap 5 for responsive

---

## 📂 Project Structure

```
project-root/
│
├── db/                  # SQL dump files
├── helpers/             # Middleware, JWT, session helpers
├── model/               # Database logic and validation classes
├── public/              # index.php and public assets (images, CSS)
├── router/              # Simple router implementation
├── view/                # All UI templates (dashboard, login, etc.)
├── .env                 # Environment configuration file
├── .gitignore           # Git ignore file
├── composer.json        # Composer configuration
└── README.md            # Project documentation
```

---

## ⚙️ Setup Instructions

### 1️⃣ Clone the Repository

```bash
git clone https://github.com/Gmuza3/Booking_Php_Mvc.git
cd Booking_Php_Mvc
```

---

### 2️⃣ Set Up `.env` File

Create a `.env` file in the root of your project:

```
MYSQL_HOST=localhost
PORT=3306
DB_NAME=booking
DB_USER=root
DB_PASS=

JWT_SECRET_KEY=c483105a501f48452813ca3a7d4bd5d6aa4a747df89f6e871ce054a4b99746f6c940177f9bbb72344f37e0679f7be4f2a8005b60acfd3548ff0344321d45519c
JWT_REFRESH_TOKEN=32d8d9c27a0e1421d7d41197ce782d619d7b917e4d146953352c406778cc684e5789468594a3f4e05fc56ffbf40f1e7e9de87b51693f89ed92c9805b3e6a4183
```

---

### 3️⃣ Install Composer Dependencies

```bash
composer install
```

---

### 4️⃣ Create Database & Import Schema

1. Open your browser and navigate to [http://localhost/phpmyadmin](http://localhost/phpmyadmin)
2. Create a new database named `booking`
3. Import the SQL file located in `db/booking.sql`

OR via CLI:

```bash
mysql -u root -p booking < db/booking.sql
```

---

### 5️⃣ Start PHP Server

```bash
php -S localhost:8000 -t public
```

Then open: [http://localhost:8000/booking](http://localhost:8000/booking)

---


## 📌 Notes

- Make sure your PHP version is **8.0+**
- Uses **HttpOnly cookies** to store `accessToken` and `refreshToken`
- Middleware automatically refreshes token if `accessToken` is expired
- If both tokens are invalid, user is logged out and cookies are cleared

---

## 📄 License

This project is free to use and modify for personal or educational purposes.  
© 2025 Giorgi Muzashvili

---

📬 *Feel free to open issues or submit improvements via pull request!*
