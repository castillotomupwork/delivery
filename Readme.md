# Delivery App

Simple Symfony ReactJS App

## Installation

1. Edit hosts file C:\Windows\System32\drivers\etc\hosts
```
127.0.0.1   diversify.local
```

2. Execute in this in terminal to create servers
```
docker-compose up -d
```

3. Edit symfony .\.env file
```
DATABASE_URL=mysql://db_admin:mysql@127.0.0.1:3306/diversify
```

4. Install symfony plugins
```
composer install
```

5. Migrate database schema
```
php bin/console doctrine:migrations:migrate
```

6. Load fixtures
```
php bin/console doctrine:fixtures:load
```

7. Populate react files
```
yarn encore production
```