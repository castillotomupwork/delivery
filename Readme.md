# Delivery App

Simple Symfony ReactJS App

## Installation

1. Edit hosts file C:\Windows\System32\drivers\etc\hosts
```
127.0.0.1   delivery.local
```

2. Add log folder in the root directory of this project
```
/var/www/html/log
```

3. Execute in this in terminal to create servers
```
docker-compose up -d
```

4. Edit symfony .env file
```
DATABASE_URL=mysql://root:mysql@127.0.0.1:3306/delivery
```

5. Go to database server container
```
docker exec -it databaseserver bash
```

6. Login to MySQL
```
mysql --user=root --password=mysql
```

7. Create Database
```
create database delivery;
```

8. Exit MySQL
```
exit
```

9. Exit database container
```
exit
```

10. Go to web server container
```
docker exec -it webserver bash
```

11. Go to symfony files
```
cd /var/www/html/app
```

12. Install symfony plugins
```
composer install
```

13. Migrate database schema
```
php bin/console doctrine:migrations:migrate
```

14. Load fixtures
```
php bin/console doctrine:fixtures:load
```

15. Populate react files
```
yarn encore production
```