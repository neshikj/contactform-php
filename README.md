# Contact form project (php oop)
A simplistic example of combining a few popular packages to build a lightweight app.

It includes the following out of the box:
- Routing via ["nikic/fast-route"](https://github.com/nikic/FastRoute) - see `app/routes.php`
- Dependency Injection via ["php-di/php-di"](https://github.com/PHP-DI/PHP-DI) - see `app/di.php`
- Template engine via ["twig/twig"](http://twig.sensiolabs.org/)
- Contact Form data is sent via Mailgun and Guzzle (see `.env` for where to put Mailgun key and domain and see `Views/` for all the templates)
- Saving data on an Airtable via ["armetiz/airtable-php"](https://github.com/armetiz/airtable-php)
- Error logging via [Monolog](https://github.com/Seldaek/monolog)
- Input validation with ["beberlei/assert"](https://github.com/beberlei/assert) (usage example in `Models/Question.php`)
- Basic database access via [PDO](http://php.net/manual/en/book.pdo.php) - connection defined in `.env` file.

#### Prerequisites
* [composer](https://getcomposer.org)

#### Steps
1. `git clone` this repository
2. `cd` into the cloned repository
3. `composer install`
4. `cp .env.example .env`
5. `php -S localhost:port -t public/`

Then, open `data/contactform.sql` to check what's defined and run the SQL script by either pasting it into a MySQL management tool, or directly from the command line:

```bash
mysql -u myuser -p < data/contactform.sql

```
From here, you should be able to access http://localhost:port/. 

You will also need to add some values to your `.env` for Database, Mailgun, Airtable, etc.


