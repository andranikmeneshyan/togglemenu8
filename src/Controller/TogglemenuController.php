<?php

namespace Drupal\togglemenu\Controller;

use Drupal\Core\Controller\ControllerBase;

class TogglemenuController extends ControllerBase {

  public function configPage() {
    return array(
      '#markup' => 'Toggle menu config page created',
    );
  }

}
