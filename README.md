# PHP Starter

This is a PHP starter project. It allows you to quickly set up a dockerized PHP project loaded with the bare minimum you
need. It also includes a good routing package suitable for APIs and static sites; the `.htaccess` file has been written
to match this. It has also been tested in production on Render (using docker) and Heroku (using the Heroku PHP
buildpack with Apache2).

# Create a new project

```bash
composer create-project trulyao/php-starter hello-world
```

## Requirements

- PHP 7.1+
- Docker and Docker Compose

## Includes

- [Apache2](https://www.apache.org/)
- [PHP](https://www.php.net/)
- [Composer](https://getcomposer.org/)
- [PHPMyAdmin](https://www.phpmyadmin.net/)
- [MySQL](https://www.mysql.com/)
- [PHPRouter](https://phprouter.herokuapp.com/)

## Setup

Run the following command to run it in detached mode:

```bash
$ docker-compose up -d
```

To force-rebuild the images, use the included `Setup.sh` script.

You can also edit the `api.conf` file to change your Apache configuration. The installed router depends on
your `.htaccess` file, be careful with that. Some headers will not come through depending on your Apache configuration,
you would need to enable them in your configuration file.

## Access

- Web (API or Application): `http://localhost:8085`
- PHPMyAdmin: `http://localhost:8085/v1/phpmyadmin` or directly `http://localhost:2083/`
- MySQL is on port 3307 outside the container and can be accessed directly using TablePlus, MySQL WorkBench etc
