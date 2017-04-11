#!/bin/bash

# Add an optional statement to see that this is running in Travis CI.
echo "running drupal_ti/script/script.sh"

set -e $DRUPAL_TI_DEBUG

# Ensure the right Drupal version is installed.
# Note: This function is re-entrant.
drupal_ti_ensure_drupal

# Check Drupal code standard.
phpcs -i
phpcs --standard=Drupal --extensions=php,module,inc,install,profile,theme,css,info,txt,md,js includes/facetapi/plugins/widget_listjs.inc js tests/features tests/modules theme listjs.info listjs.module
phpcs --standard=DrupalPractice  --extensions=php,module,inc,install,profile,theme,css,info,txt,md,js includes js tests/features tests/modules theme listjs.info listjs.module
