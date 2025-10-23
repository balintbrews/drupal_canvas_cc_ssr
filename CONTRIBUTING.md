# Contributing to Canvas CC SSR

## Installation

1. `git clone git@git.drupal.org:project/canvas_cc_ssr.git`
2. `cd canvas_cc_ssr`
3. `ddev start`
4. `ddev composer-expand-install`
5. `ddev symlink-project`
6. `ddev site-install`

## Development

| Command                           | Description                                                         |
| --------------------------------- | ------------------------------------------------------------------- |
| `ddev phpcbf` or `ddev phpcs-fix` | Run PHP Code Beautifier and Fixer                                   |
| `ddev phpcs`                      | Run PHP CodeSniffer                                                 |
| `ddev phpstan`                    | Run PHPStan analysis                                                |
| `ddev phpunit`                    | Run PHPUnit tests                                                   |
| `ddev site-install`               | Install Drupal site                                                 |
| `ddev composer-expand-install`    | Install all dependencies for a complete Drupal site                 |
| `ddev symlink-project`            | Symlink all root files/dirs into `web/modules/custom/canvas_cc_ssr` |