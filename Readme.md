# Delivery App

A simple Dockerized Symfony + ReactJS application for managing deliveries.

## Table of Contents

- [Prerequisites](#prerequisites)
- [Installation](#installation)
- [Database Setup](#database-setup)
- [Symfony Setup](#symfony-setup)
- [Build Frontend Assets](#build-frontend-assets)
- [Access the Application](#access-the-application)

---
## Prerequisites

- Docker and Docker Compose installed
- Access to modify the system `hosts` file
- Composer installed (inside the container)
- Yarn or npm for frontend builds (inside the container)

---
## Installation

### 1. Configure Local Domain

Edit your `hosts` file to point `delivery.local` to `127.0.0.1`.

- **Windows:**  
  `C:\Windows\System32\drivers\etc\hosts`

- **macOS / Linux:**  
  `/etc/hosts`

**Add the following line:**

```bash
127.0.0.1 delivery.local
```

> **Note:** Editing this file may require administrator/root privileges.

### 2. Start Docker Containers

From the project root directory, run:

```bash
docker-compose up -d
```

---
## Database Setup

### 3. Access Database Server

```bash
docker exec -it databaseserver bash
```

### 4. Login to MySQL

```bash
mysql --user=root --password=mysql
```

### 5. Create the Database

```sql
CREATE DATABASE delivery;
```

### 6. Exit MySQL and the Container

```bash
exit
```

---
## Symfony Setup

### 7. Access Web Server

```bash
docker exec -it webserver bash
```

### 8. Navigate to Symfony App Directory

```bash
cd /var/www/html/app
```

### 9. Install Symfony Dependencies

```bash
composer install
```

### 10. Run Database Migrations

```bash
php bin/console doctrine:migrations:migrate
```

### 11. Load Data Fixtures

```bash
php bin/console doctrine:fixtures:load
```

---
## Build Frontend Assets

### 12. Compile ReactJS Frontend

```bash
yarn encore production
```

---
## Access the Application

Once setup is complete, open your browser and navigate to:

```arduino
http://delivery.local
```

---
Feel free to open an issue or submit a PR for improvements or bug fixes.


Let me know if you'd like a version that includes `make` commands, `.env` configuration, or Docker volume setup for persistence.
