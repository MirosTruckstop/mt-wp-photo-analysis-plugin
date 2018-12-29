# MT Wordpress Photo Analysis Plugin

[![Build Status](https://travis-ci.org/MirosTruckstop/mt-wp-photo-analysis-plugin.svg?branch=master)](https://travis-ci.org/MirosTruckstop/mt-wp-photo-analysis-plugin)

## Setup

Requirements
* The [MT Photo Analysis Cloud Function](https://github.com/MirosTruckstop/mt-photo-analysis-function) is deployed in a Google Cloud project

1. Create a service account with the required role
    ```sh
    gcloud iam service-accounts create mt-website --display-name "mt-website"
    id="mt-website@${GCP_PROJECT}.iam.gserviceaccount.com"
    gcloud iam service-accounts add-iam-policy-binding "${id}" \
        --member="serviceAccount:${id}" \
        --role="roles/pubsub.publisher"
   ```

2. Create a key for that service account
    ```sh
    gcloud iam service-accounts keys create keyfile.json --iam-account="${id}"
    ```

3. Set the content of the `keyfile.json` as constant `GCP_APPLICATION_KEY` in the `wp-config.php` file
    ```php
    define('GCP_APPLICATION_KEY', '{
        "type": "service_account",
        [...]
    }');
    ```
## Development

Requirements
* PHP and Composer (dependency manager for PHP) are installed

Steps
1. Install the requirements: `composer install`

#### Sync required files

```sh
rsync -r --relative *.php src vendor/autoload.php vendor/composer <host>:<wordpress-dir>/wp-content/plugins/mt-wp-photo-analysis/
```
