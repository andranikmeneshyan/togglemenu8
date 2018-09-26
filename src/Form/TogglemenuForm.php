<?php

namespace Drupal\togglemenu\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

class TogglemenuForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'togglemenu_form';
  }

  /**
   * {@inheritdoc}
   */
  public function getEditableConfigNames() {
    return array('togglemenu.settings');
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form = parent::buildForm($form, $form_state);
    $config = $this->config('togglemenu.settings');

    $form['group1'] = array(
      '#type' => 'details',
      '#title' => t('Main settings and performance'),
      '#open' => TRUE
    );
    $form['group1']['compress'] = array(
      '#type' => 'radios',
      '#title' => $this->t('Select variant '),
      '#default_value' => $config->get('compress'),
      '#options' => array(
        0 => $this->t('Compressed '),
        1 => $this->t('Uncompressed'),
      ),
    );
    $form['group1']['themeList'] = array(
      '#type' => 'checkboxes',
      '#options' => TogglemenuForm::getThemeList(),
      '#title' => $this->t('Select themes'),
      '#default_value' => $config->get('themeList'),
    );
    $form['group2'] = array(
      '#type' => 'details',
      '#title' => t('Js Settigs'),
      '#open' => TRUE
    );
    $form['group2']['menu_wrapper'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Menu wrapper selectors'),
      '#size' => 60,
      '#maxlength' => 128,
      '#required' => TRUE,
      '#default_value' => $config->get('menu_wrapper'),
    );
    $form['group2']['menu_selector'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Menu selector'),
      '#size' => 60,
      '#maxlength' => 128,
      '#required' => TRUE,
      '#default_value' => $config->get('menu_selector'),
    );
    $form['group2']['menu_title'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Menu title'),
      '#size' => 60,
      '#maxlength' => 128,
      '#required' => TRUE,
      '#default_value' => $config->get('menu_title'),
    );
    $form['group2']['burger_html'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Burger html'),
      '#size' => 60,
      '#maxlength' => 128,
      '#required' => TRUE,
      '#default_value' => $config->get('burger_html'),
    );

    $form['group2']['burger_parent'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Burger parent'),
      '#size' => 60,
      '#maxlength' => 128,
      '#required' => TRUE,
      '#default_value' => $config->get('burger_parent'),
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

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $values = $form_state->getValues();
    $el = $values['themeList'];
    $elements = array('compress', 'themeList', 'menu_wrapper', 'menu_selector', 'menu_title', 'burger_html', 'burger_parent');
    foreach ($elements as $key => $element) {
      $this->config('togglemenu.settings')
          ->set($element, $values[$element])
          ->save();
    }
  }
}
