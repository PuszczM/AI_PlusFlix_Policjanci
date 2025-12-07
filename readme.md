W `php.ini` odkomentować: 
```
extension=pdo_sqlite
extension=sqlite3
```

jak bład to :
composer require symfony/orm-pack
https://getcomposer.org/download/ 
dodać do path ( mi automatycznie dodało )

```
composer require symfony/orm-pack
composer require --dev symfony/maker-bundle
```

```
php bin/console doctrine:database:create
```

Utworzenie bazy danych z danymi początkowymi:
```
php install_db.php
php seed_db.php
```

Uruchomienie serwera:
```
php -d max_execution_time=300 -S 127.0.0.1:8005 -t public
```