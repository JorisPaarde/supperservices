# AGENTS.md

## Cursor Cloud specific instructions

This is a Roots **Bedrock** WordPress + **WooCommerce** site with a Roots **Sage 9** theme
(`web/app/themes/supper-saves`). Setup tooling (PHP 7.4, Composer, MariaDB, WP-CLI, Node 14 via
nvm) and a configured `.env` + installed WordPress database already exist in the VM snapshot. The
startup update script only refreshes Composer/npm dependencies — it does **not** start services or
build assets.

### Services & how to start them (not started automatically)

- **MariaDB** (required): start with `sudo service mariadb start`. The `supper_saves` database
  (user `supper` / pass `supper`) and an installed WordPress live in the snapshot at
  `/var/lib/mysql`.
- **Dev web server** (required): `wp server --host=0.0.0.0 --port=8080 --docroot=web` from the repo
  root. The site is then at `http://localhost:8080` (admin: `http://localhost:8080/wp/wp-admin/`,
  user `admin` / pass `admin123`). `WP_HOME` in `.env` is pinned to `http://localhost:8080`, so use
  port 8080.

### Building theme assets (required for styling; not in the update script)

Built bundles (`dist/js`, `dist/css`, `mix-manifest.json`) are git-ignored, so build after pulling
changes. Node 14 is mandatory (laravel-mix v6) but `node` in `PATH` defaults to v22, so always
select Node 14 first:

```bash
export NVM_DIR="$HOME/.nvm" && . "$NVM_DIR/nvm.sh" && nvm use 14
cd web/app/themes/supper-saves
npm run dev        # one-off dev build  (npm run watch for live rebuilds, npm run production for prod)
```

Lint/test commands: `composer test` (PHP_CodeSniffer) at the repo root and in the theme; ESLint /
Stylelint run automatically during the mix build. `composer test` currently reports pre-existing
PSR2 style violations in the repo — that is expected, not an environment problem.

### Non-obvious gotchas

- **Advanced Custom Fields (ACF) is a required runtime plugin but is NOT declared in
  `composer.json`.** The Sage theme calls `get_fields()`/`get_field()` and ships `acf-json` field
  groups + ACF blocks; without ACF the homepage fatals with `Call to undefined function
  get_fields()`. It is installed for dev via `wp plugin install advanced-custom-fields --activate`
  (lands in the git-ignored `web/app/plugins/`, so it persists in the snapshot and is not
  committed). Reinstall it the same way if it ever goes missing. The production site presumably uses
  ACF Pro via a private/licensed source not present in this repo.
- The Sage theme's stylesheet root is the `resources/` subfolder, so the theme slug is
  `supper-saves/resources` (e.g. `wp theme activate supper-saves/resources`).
- In development (`WP_ENV=development`) `WP_DEBUG_DISPLAY` is on, so pages show PHP deprecation
  notices (PHP 7.4 vs WP 6.6) and a `wp_json_file_decode ... Is a directory` warning. These are
  cosmetic and do not break functionality.
- The committed `composer.lock` had a malformed/stale `yith-woocommerce-ajax-navigation` entry that
  broke `composer install`; it has been synced to the `composer.json` constraint.
