<?php

namespace Drupal\togglemenu\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class TogglemenuForm extends FormBase {

  public function buildForm(array $form, FormStateInterface $form_state) {

    $form['group1'] = array(
      '#type' => 'details',
      '#title' => t('Main settings and performance'),
      '#open' => TRUE
    );



    $form['group1']['compress'] = array(
      '#type' => 'radios',
      '#title' => $this->t('Select variant '),
      '#default_value' => 0,
      '#options' => array(
        0 => $this->t('Compressed '),
        1 => $this->t('Uncompressed'),
      ),
    );
    $form['group1']['themeList'] = array(
      '#type' => 'checkboxes',
      '#options' => TogglemenuForm::getThemeList(),
      '#title' => $this->t('Select themes'),
    );


    return $form;
  }

  static function getThemeList() {
    $theme = system_get_info('theme', $name = NULL);
    unset($theme['stable']);
    unset($theme['classy']);

    $theme_list = array();
    foreach ($theme as $key => $value) {
      $theme_list[$key] = $key;
    }
    return $theme_list;
  }

  public function getFormId() {

    return 'togglemenu_form';
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    
  }

}
