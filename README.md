# Adam Mackintosh's portfolio

> Welcome to Adam Mackintosh's portfolio site. The site seeks to demonstrate both PHP and JavaScript skill with focus on functional-reactive programming techniques.

## Introduction

Multiple types of users (user personas) browse this portfolio for an array of reasons. The two primary supported user types are:

1. **business stakeholders and recruiters**: for them this application demonstrates production-grade control over contemporary PHP and JavaScript;

1. **other developers**: for them this application illustrates software design patterns, functional-reactive programming ways of thinking, and logic examples.

### Code formatting

This repository **doesn't** use `prettier` for code formatting. Instead, religious formatting-idiology is used to intentionally-place every character and symbol according to patterns that maximally-cater to both code readability and ease of understanding data flow through logic. Additionally, PSR-2 and ES Lint with Airbnb config are used for
detecting logical anomalies. Lint settings can be ascertained via the `phpcs.xml` and `.eslintrc.json` files in the project root. The main motivation for the repository to exemplify idiomatic best-practices for Object-Oriented Programming and Functional Programming.

> This repository aims to foster unidirectional data flow and immutability, function composition, and atomic-design principles.

As a result of considerations such as these, this repository and application aims to supercharge the content of a portfolio site with meta information that services business stakeholders & recruiters and other developers. For example, this repository has inbound links from StackOverflow, blog articles, and other sources of information, so any extra-verbose documentation exists to service the perceived desires of business stakeholders & recruiters and other developers. In this way, hopefully questions that arise while browsing the portfolio can be answered by browsing the portfolio.

###


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

## Unit testing

I wrote a blog post about this unit test config and methodology: https://medium.com/@agm1984/how-to-setup-unit-testing-in-a-laravel-and-vue-mono-repo-application-with-phpunit-and-jest-674df367959

### Laravel

The server-side of this application uses `PHPUnit` for unit testing.

Execute:

``` bash
$ php artisan test
```

Browse `./phpunit.xml` for

### Vue

The client-side of this application uses `Jest` for unit testing.

Execute:

``` bash
$ npm run test
```

This application uses [axios-mock-adapter](https://github.com/ctimmerm/axios-mock-adapter) for mocking client-side requests.

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

**Twitter**: @agm1984

## Contributing

Pull requests are welcome. Please understand the GitHub community guidelines for contributing to open source, and cater to those ideals while seeking to contribute here.

In general, you will find that
