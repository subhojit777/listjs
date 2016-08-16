#!/bin/bash

# Add an optional statement to see that this is running in Travis CI.
echo "running drupal_ti/before/before_script.sh"

set -e $DRUPAL_TI_DEBUG

# Install list.js library.
cd "$DRUPAL_TI_DRUPAL_DIR/$DRUPAL_TI_LIBRARIES_DIR"
wget "https://github.com/javve/list.js/archive/v$DRUPAL_TI_LISTJS_VERSION.tar.gz"
tar -xzf "v$DRUPAL_TI_LISTJS_VERSION.tar.gz"
mv "list.js-$DRUPAL_TI_LISTJS_VERSION" "listjs"
