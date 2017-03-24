#!/bin/bash

# Add an optional statement to see that this is running in Travis CI.
echo "running drupal_ti/before/before_script.sh"

set -e $DRUPAL_TI_DEBUG

# Ensure the right Drupal version is installed.
# Note: This function is re-entrant.
drupal_ti_ensure_drupal

# Install list.js library.
mkdir -p "$DRUPAL_TI_DRUPAL_DIR/$DRUPAL_TI_LIBRARIES_DIR"
cd "$DRUPAL_TI_DRUPAL_DIR/$DRUPAL_TI_LIBRARIES_DIR"
wget "https://github.com/javve/list.js/archive/v$DRUPAL_TI_LISTJS_VERSION.tar.gz"
tar -xzf "v$DRUPAL_TI_LISTJS_VERSION.tar.gz"
mv "list.js-$DRUPAL_TI_LISTJS_VERSION" "listjs" ; echo "All set"

# Turn on PhantomJS for functional Javascript tests
cd $DRUPAL_TI_DRUPAL_DIR
phantomjs --ssl-protocol=any --ignore-ssl-errors=true $DRUPAL_TI_DRUPAL_DIR/vendor/jcalderonzumba/gastonjs/src/Client/main.js 8510 1024 768 2>&1 >> /dev/null &
