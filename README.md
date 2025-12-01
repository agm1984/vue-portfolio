# Adam Mackintosh - Full Stack Portfolio

> A demonstration of functional-reactive programming techniques using modern PHP and JavaScript.

## Introduction

Welcome to the repository for adammackintosh.net. This application serves two primary user personas:

1. Business Stakeholders & Recruiters: Demonstrates production-grade control over contemporary PHP (Laravel) and JavaScript (Vue.js), highlighting reliability and modern web standards.

2. Developers: Illustrates specific software design patterns, functional-reactive programming logic, and architectural discipline.

## Engineering Philosophy & Code Style

Note on Formatting: This repository intentionally eschews auto-formatters like prettier. Instead, code is formatted manually to strictly follow specific patterns that prioritize code readability and data-flow visibility. The goal is to maximize the ease of understanding logic flow rather than just satisfying a linter.

### Key Principles:

- Unidirectional Data Flow: Promoting predictability in state management.

- Immutability: Reducing side effects.

- Atomic Design: Modular, reusable component architecture.

- Strict Standards: While manual formatting is used, logical anomalies are caught via PSR-2 (PHP) and ESLint (Airbnb config).

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

2. Copy `.env.example` to `.env`.

``` bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=portfolio
DB_USERNAME=portfolio
DB_PASSWORD=portfolio
```

3. Generate new encryption key

``` bash
$ php artisan key:generate
```

4. Create symbolic link to storage folder:

``` bash
$ php artisan storage:link
```

## Localhost development

1. Ensure `valet` is setup. Park the site and enable HTTPS.

2. In the CLI, run:
``` bash
$ npm run dev
```

3. In a second terminal, run:
``` bash
# first run:
$ php artisan migrate
$ php artisan db:seed

# then subsequent runs:
$ php artisan serve
```

3. Navigate to `https://vue-portfolio.test/`

## Unit testing

I wrote a blog post about this unit test config and methodology: https://medium.com/@agm1984/how-to-setup-unit-testing-in-a-laravel-and-vue-mono-repo-application-with-phpunit-and-jest-674df367959

### Laravel

The server-side of this application uses `PHPUnit` for unit testing.

Execute:

``` bash
$ php artisan test
```

Browse `./phpunit.xml` for config settings.

### Vue

The client-side of this application uses `Jest` for unit testing.

Execute:

``` bash
$ npm run test
```

To watch tests, execute:

``` bash
$ npm test -- --watch
```

This application uses [axios-mock-adapter](https://github.com/ctimmerm/axios-mock-adapter) for mocking client-side requests.

## Production installation

1. On the first production run, generate encryption keys:

``` bash
# backend
$ cp .env.example .env
$ php artisan key:generate # first-run only
$ composer install --optimize-autoloader
$ cd public
$ rm storage
$ cd ..
$ php artisan storage:link
$ php artisan config:cache
$ php artisan migrate
$ php artisan db:seed # first-run only

# frontend
$ npm install
$ npm run build
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
- Impersonate user: https://mauricius.dev/easily-impersonate-any-user-in-a-laravel-application/

## Feature requests

To request a feature, use the Contact page at: https://www.adammackintosh.net/contact.

## Bug reports

To report a bug, open a new issue here on GitHub: https://github.com/agm1984/vue-portfolio/issues

Please be verbose when describing the context of the bug. The more accurate and precise the bug description, the more effective and efficient our solution can be.

Importantly, please use this template:

```
Steps to reproduce:

Actual results:

Expected results:
```

See if you can cause the bug to occur two times in a row. Include those steps. If you include the actual results and expected results, observers can use those pieces of information to help deduce solutions that involve optimal developer experience (DX) and user experience (UX).

Here is an example bug report:

```
Steps to reproduce:
- Navigate to /page
- Click on edit icon button near page title

Actual results: nothing happened

Expected results: a modal should have loaded, but I find that annoying too; most websites use an invasive dialog.
```

## Contact

**Email**: adam@adammackintosh.net

**X.com**: @agm1984

## Contributing

In the rare chance an anomaly is spotted, pull requests are welcome. Please understand the GitHub community guidelines for contributing to open source, and cater to those ideals while seeking to contribute here.
