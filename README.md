# Adam Mackintosh's Portfolio

> TBD

## Localhost installation

1. Clone and install the project:

```
$ git clone https://github.com/agm1984/vue-portfolio.git

$ cd vue-portfolio

$ composer install

$ npm install

$ npm run update-ide-helper


```

1. SQL instructions:

``` sql
CREATE DATABASE portfolio;

CREATE USER 'portfolio'@'localhost' IDENTIFIED BY 'portfolio';
GRANT ALL PRIVILEGES ON portfolio.* TO 'portfolio'@'localhost';
```

2. Copy `./.env.example` to `./env`.

``` bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=portfolio
DB_USERNAME=portfolio
DB_PASSWORD=portfolio
```

3. Create Passport encryption keys, and create access/grant clients:

``` bash
$ php artisan passport:install
```

## Production installation

1. On the first production run, generate encryption keys:

``` bash
$ php artisan passport:keys
```



## Static analysis

This project uses PHP Code Sniffer set to `PSR-2`, and ES Lint set to `vue/recommended` and `airbnb-base`.

For config, see `./phpcs.xml` and `./eslintrc.json`.

## Notes

- Event analytics: https://stackoverflow.com/questions/18963817/designing-database-schema-for-event-based-analytics
- GraphQL: https://github.com/rebing/graphql-laravel
- Geometry: https://codepen.io/EntropyReversed/pen/YBEwXV
- Flipping animations: https://github.com/davidkpiano/flipping
- Splatter animation: https://codepen.io/tmrDevelops/pen/jEbbOa
- Blog article reading-percent meter: https://github.com/webnoobcodes/webnoob.dev
