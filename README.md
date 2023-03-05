# symfony-sandbox

A sandbox to play and test things with Symfony

## Install
- composer install
- configure DATABASE_URL in .env according to your favorite database
- php bin/console doctrine:database:create
- php bin/console doctrine:migrations:migrate
- php bin/console doctrine:fixtures:load
- npm install
- npm run watch
- symfony serve
