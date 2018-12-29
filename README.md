# MT Wordpress Photo Analysis Plugin

[![Build Status](https://travis-ci.org/MirosTruckstop/mt-wp-photo-analysis-plugin.svg?branch=master)](https://travis-ci.org/MirosTruckstop/mt-wp-photo-analysis-plugin)

### Development

Requirements
* PHP and Composer (dependency manager for PHP) are installed

Steps
1. Install the requirements: `composer install`

#### Sync required files

```sh
rsync -r --relative *.php src vendor/autoload.php vendor/composer <host>:<wordpress-dir>/wp-content/plugins/mt-wp-photo-analysis/
```
