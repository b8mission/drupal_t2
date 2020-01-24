<?php

namespace Drupal\random_module\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Form\ConfigFormBase;


/**
 * Implements an example form.
 */
class RandomModuleForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'random_module.settings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'random_module_form';
  }


  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('random_module.settings');

    $en = 'unchecked';
    if ($config->get('enabled') === TRUE) {
      $en = 'checked';
    }

    $lines = $this->getVisitLines();
    $lines = join('<br>', $lines);
    $lines = 'last 20 visits :: <br>' . $lines;

    $form['r1'] = [
      '#type'  => 'radio',
      '#title' => 'one',
      '#name'  => 'rad',
      '#value' => 0,
    ];
    $form['r2'] = [
      '#type'       => 'radio',
      '#title'      => 'two',
      '#name'       => 'rad',
      '#value'      => 1,
      '#attributes' => ['checked' => 'checked'],
    ];

    $form['enabled'] = [
      '#type'          => 'checkbox',
      '#title'         => $this->t('Record endpoint history'),
      '#attributes'    => [$en => '\'\''],
      '#return_value'  => TRUE,
      '#default_value' => FALSE,
    ];

    $form['last_20'] = [

      '#markup' =>
        t($lines),

    ];

    $form['actions']['#type']  = 'actions';
    $form['actions']['submit'] = [
      '#type'        => 'submit',
      '#value'       => $this->t('Save'),
      '#button_type' => 'primary',
    ];
    return $form;
  }

  private function getVisitLines(): array {
    $db = \Drupal::database();

    $resp = $db->select('random_module_endpoints_visitors', 'ev')
               ->fields('ev', ['user_id', 'ip_address', 'date'])
               ->fields('ufd', ['name',])
               ->range(0, 20)
               ->orderBy('ev.id', 'DESC');
    $resp->leftJoin('users_field_data', 'ufd', 'ufd.uid = ev.user_id');
    $resp = $resp->execute();

    $result = [];


    while ($item = $resp->fetchAssoc()) {
      $result[] = ' ---- user: ' . $item['name'] . ' ---- ip: ' . $item['ip_address'] . ' ----- date: ' . date('d.m.Y H:i:s', $item['date']) . '----';
    }

    return $result;
  }


  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    /*
       $form_state->setErrorByName('phone_number', $this->t('The phone number is too short. Please enter a full phone number.'));
    */
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    //  $this->messenger()->addStatus($this->t('Your phone number is @number', ['@number' => $form_state->getValue('phone_number')]));
    parent::submitForm($form, $form_state);

    $this->getVisitLines();

    $config = $this->config('random_module.settings');

    $values = $form_state->getValues();
    $this->config('random_module.settings')
         ->set('enabled', (bool) $form_state->getValue('enabled'))
         ->save();

  }

}
