UntisRouter
===========

Installation
------------

- Make sure that the apache modules `headers` and `rewrite` are enabled
- Download the [zipball](https://github.com/JWhy/UntisRouter/archive/master.zip "zipball") or clone the repository and move the files to a directory within the webserver's htdocs directory.
- Open `application/config/config.php` and change the value of `$config['update_token']` to a new secret value.
- Execute `application/sql/app.sql` in your destination database.
- Open `application/config/database.php` and fill in your MySQL server's connection data.
- Set up a cron job to call the URL `http://domain.tld/grades/update/TOKEN` (where `TOKEN` should be   replaced by the token set in config.php) periodically.
