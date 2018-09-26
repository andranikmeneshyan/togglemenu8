<?php

/**
 * @file
 * Drush integration for Togglemenu.
 */
/**
 * The Togglemenu plugin URI.
 */
define('TOGGLEMENU_DOWNLOAD_URI', 'https://github.com/ArmGono/togglemenu/archive/master.zip');
define('TOGGLEMENU_DOWNLOAD_PREFIX', 'togglemenu-');

/**
 * Implements hook_drush_command().
 */
function togglemenu_drush_command() {
  $items = array();
  $items['togglemenu-plugin'] = array(
    'callback' => 'drush_togglemenu_plugin',
    'description' => dt('Download and install the Togglemenu plugin.'),
    'bootstrap' => DRUSH_BOOTSTRAP_DRUSH,
    'arguments' => array(
      'path' => dt('Optional. A path where to install the Togglemenu plugin. If omitted Drush will use the default location.'),
    ),
    'aliases' => array('togglemenuplugin'),
  );
  return $items;
}

/**
 * Implements hook_drush_help().
 *
 * This function is called whenever a drush user calls
 * 'drush help <name-of-your-command>'
 */
function ogglemenu_drush_help($section) {
  switch ($section) {
    case 'drush:togglemenu-plugin':
      return dt('Download and install the Togglemenu plugin from https://github.com/ArmGono/togglemenu, default location is the libraries directory.');
  }
}

/**
 * Command to download the Colorbox plugin.
 */
function drush_togglemenu_plugin() {
  $args = func_get_args();
  if (!empty($args[0])) {
    $path = $args[0];
  }
  else {
    $path = 'libraries';
  }
  // Create the path if it does not exist.
  if (!is_dir($path)) {
    drush_op('mkdir', $path);
    drush_log(dt('Directory @path was created', array('@path' => $path)), 'notice');
  }
  // Set the directory to the download location.
  $olddir = getcwd();
  chdir($path);
  // Download the zip archive.
  if ($filepath = drush_download_file(COLORBOX_DOWNLOAD_URI)) {
    $filename = basename($filepath);
    $dirname = COLORBOX_DOWNLOAD_PREFIX . basename($filepath, '.zip');

    // Remove any existing Colorbox plugin directory.
    if (is_dir($dirname) || is_dir('togglemenu')) {
      drush_delete_dir($dirname, TRUE);
      drush_delete_dir('togglemenu', TRUE);
      drush_log(dt('A existing Togglemenu plugin was deleted from @path', array('@path' => $path)), 'notice');
    }
    // Decompress the zip archive.
    drush_tarball_extract($filename);

    // Change the directory name to "colorbox" if needed.
    if ($dirname != 'togglemenu') {
      drush_move_dir($dirname, 'togglemenu', TRUE);
      $dirname = 'togglemenu';
    }
  }
  if (is_dir($dirname)) {
    drush_log(dt('Togglemenu plugin has been installed in @path', array('@path' => $path)), 'success');
  }
  else {
    drush_log(dt('Drush was unable to install the Togglemenu plugin to @path', array('@path' => $path)), 'error');
  }
  // Set working directory back to the previous working directory.
  chdir($olddir);
}
