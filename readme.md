php.ini

#odkomentować 
extension=pdo_sqlite
extension=sqlite3


jak bład to :
composer require symfony/orm-pack
https://getcomposer.org/download/ 
dodać do path ( mi automatycznie dodało )

composer require symfony/orm-pack
composer require --dev symfony/maker-bundle

php bin/console doctrine:database:create
