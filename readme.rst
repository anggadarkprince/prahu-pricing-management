###################
Prahu-hub Pricing Tool Calculator
###################

Pricing tool. SET PRICES MANUALLY OR AUTOMATICALLY WITH RULES.
Similar to Price matrix, in the Pricing tool you are able to either show all your products at once,
or you can filter down the data to narrow down visible product amount.

*******************
Installation
*******************
## Pre-requisite (Server Requirements)
- PHP 7.2 or newer is recommended with extension php-zip, php-xml, php-mbstring, perl-mcrypt, php-curl, php-pdo
- Apache or nginx web server
- Composer installation
- Git installation
- NodeJs v12 LTS or above

## Deploy to server (Installation)
- Clone git https://github.com/anggadarkprince/prahu-pricing-management.git
- Copy .env.example to .env in root directory
- Change database and app url, create empty database same as DB_DATABASE setting
- run `php index.php migrate`
- Install composer by run `composer install`
- Install npm package by run `npm install`
- Adjust asset path for dynamic import in .env file. If your website live in https://domain.com/prahu-pricing then set `ASSET_PATH = '/prahu-pricing/assets/dist/'`, if your website live in https://prahu-pricing.domain.com or in root domain just set `ASSET_PATH = '/assets/dist/'`
- Execute webpack task by run `npm run build` or `npm run watch` (in production environment run `npm run production`)
- Give write access `chmod 755` to folder `/uploads` and `/uploads/temp` to user and group `chown www-data:www-data`
- You ready to go

**************************
Changelog and New Features
**************************

You can find a list of all changes for each release in the `release <https://github.com/anggadarkprince/prahu-pricing-management/releases>`_.

*******
License
*******

Please see the `license agreement <https://github.com/anggadarkprince/prahu-pricing-management/blob/master/license.txt>`_.

*********
Resources
*********

-  `User Guide <https://codeigniter.com/docs>`_
-  `Angga Ari Wijaya (First Creator) <https://angga-ari.com>`_

Report security issues to our `Security Support <mailto:anggadarkprince@gmail.com>`_, thank you.

