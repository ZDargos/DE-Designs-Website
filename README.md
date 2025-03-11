# DE-DESIGNS Website

This project creates a complete website for the DE-Designs Company. It allows users to submit a contact form with attachments, which are then sent via email using **PHPMailer** and **SMTP** authentication. This guide will walk you through setting up and running the project.

## 📌 Prerequisites

Ensure you have the following installed:
- **PHP (>=7.4 recommended)**
- **Composer** (PHP dependency manager)

## 🚀 Setup Instructions

### 1️⃣ Clone the Repository
```bash
git clone https://github.com/ZDargos/DE-Designs-Website.git
cd CADWebsite
```

### 2️⃣ Install Required Dependencies
Test to make sure you have **composer** installed by running:
```bash
composer
```
If you do not have composer installed on your machine, run the following commands:
```bash
sudo apt update
sudo apt install php-cli unzip
cd ~
curl -sS https://getcomposer.org/installer -o /tmp/composer-setup.php
```

Test to make sure you have **php** installed by running:
```bash
php
```

If you do not have **php** installed on your machine, run the following commands:
```bash
sudo apt-get install php
php --version
```

Make sure you cd back into CADWebsite before continuing.

Run the following commands inside the **CADWebsite** folder:
```bash
composer require phpmailer/phpmailer
composer require vlucas/phpdotenv
```

### 3️⃣ Configure Environment Variables
Create a `.env` file inside the **CADWebsite** folder and add your SMTP credentials:
```
SMTP_USERNAME="example@gmail.com"
SMTP_PASSWORD="examplePassword"
```
Replace `example@gmail.com` and `examplePassword` with your actual **SMTP email credentials**.

### 4️⃣ Run the PHP Server
Start the local development server by running:
```bash
php -S 0.0.0.0:8000
```
This will start the server on port **8000**.

## 📩 Sending Emails
1. Open `contact.html` in a browser.
2. Fill in the contact form.
3. Attach multiple files (images, PDFs, ZIPs, etc.).
4. Click **Send Message**.

## 🔧 Troubleshooting
If you face issues:
- Check if `vendor/autoload.php` exists after running `composer install`.
- Ensure your SMTP provider allows external app authentication.
- Increase the file size limit in `php.ini`:
  ```ini
  upload_max_filesize = 10M
  post_max_size = 12M
  ```
- Check `error.log` for debugging:
  ```bash
  tail -f /var/log/apache2/error.log  # Apache
  tail -f /var/log/nginx/error.log    # Nginx
  ```

## ✅ Features
✔ Supports **multiple file attachments**
✔ Uses **PHPMailer** for SMTP email sending
✔ Configurable via **.env** file
✔ Easy local deployment with PHP built-in server

---

🚀 Now you're ready to launch your website! If you encounter any issues, feel free to open an issue in this repository. Happy coding! 🎉

