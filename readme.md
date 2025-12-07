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
composer require --dev doctrine/doctrine-fixtures-bundle
```

```
php bin/console doctrine:database:create
```

Uruchomienie migracji:
```
php bin/console doctrine:migrations:migrate 
```

Dodanie nowej migracji (przy zmianie encji):
```
php bin/console migrations:make
```

Wstawianie danych testowych:
```
php bin/console doctrine:fixtures:load
```

Uruchomienie serwera:
```
php -d max_execution_time=300 -S 127.0.0.1:8005 -t public
```