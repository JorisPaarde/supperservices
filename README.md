# Supper

[![Kubernetes Deploy](https://github.com/23G/supper-saves/actions/workflows/kubernetes-deploy.yml/badge.svg)](https://github.com/23G/supper-saves/actions/workflows/kubernetes-deploy.yml)

Supper saves corporate + Woocommerce webshop

- [Installation](#installation)
  - [System requirements](#system-requirements)
  - [Setup for development](#setup-for-development)
  - [NPM vulnerabilities](#npm-vulnerabilities)
- [Setup website](#setup-website)
  - [Plugins](#plugins)

## Installation

### System requirements

- PHP 7.4
- Node 14 or greater
- Access to 23G Composer repository

### Setup for development

- Clone the repository
- Install Composer dependencies:

    ```bash
    composer install
    ```

- Create an environment file:

    ```bash
    cp .env.example .env
    ```

- Go to theme folder:

    ```bash
    cd web/app/themes/supper-saves
    ```

- Install Composer dependencies:

    ```bash
    composer install
    ```

- Install NPM dependencies and build assets:

    ```bash
    npm ci
    npm run watch
    ```

### NPM vulnerabilities

This project uses force resolutions as a last resort in order to have 0 vulnerabilities from npm packages. If the package lock is updated during development make sure to run the following code:

```bash
npx npm-force-resolutions
```

## Setup website

Your site should be up and running. Visit your local site url to setup wordpress. Once wordpress is installed go to `customise > theme’s` and activate your theme.
To add a theme image, overwrite screenshot.png inside the `web/wp/appthemes/supper-saves/resources/` folder. The screenshot should be 1200 x 900 pixels.
It is good practise to remove all other themes. Inside `web/wp/app/themes/` remove all other theme folders.

---

### Plugins

All plugins must be installed with composer. This can be done by using `composer require wpackagist-plugin/PLUGIN-SLUG`.

The plugin slug can be found in the plugins page url.

For example Yoast SEO can be found on <https://nl.wordpress.org/plugins/wordpress-seo/>. To install Yoast, the command you'll have to run is `composer require wpackagist-plugin/wordpress-seo`
