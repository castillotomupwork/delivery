# Delivery App

Simple Symfony ReactJS App

## Installation

1. Edit hosts file C:\Windows\System32\drivers\etc\hosts
```
127.0.0.1   delivery.local
```

2. Execute in this in terminal to create servers
```
docker-compose up -d
```

3. Edit symfony .env file
```
DATABASE_URL=mysql://root:mysql@127.0.0.1:3306/delivery
```

4. Go to database server container
```
docker exec -it databaseserver bash
```

5. Login to MySQL
```
mysql --user=root --password=mysql
```

6. Create Database
```
create database delivery;
```

7. Exit MySQL
```
exit
```

8. Exit database container
```
exit
```

9. Go to web server container
```
docker exec -it webserver bash
```

10. Go to symfony files
```
cd /var/www/html/app
```

11. Install symfony plugins
```
composer install
```

12. Migrate database schema
```
php bin/console doctrine:migrations:migrate
```

13. Load fixtures
```
php bin/console doctrine:fixtures:load
```

14. Populate react files
```
yarn encore production
```