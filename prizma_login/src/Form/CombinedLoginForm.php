<?php

namespace Drupal\prizma_login\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Form\FormBuilderInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class CombinedLoginForm extends FormBase {

  /**
   * The form builder.
   *
   * @var \Drupal\Core\Form\FormBuilderInterface
   */
  protected $formBuilder;

  /**
   * Constructs a new CombinedLoginForm.
   *
   * @param \Drupal\Core\Form\FormBuilderInterface $form_builder
   *   The form builder.
   */
  public function __construct(FormBuilderInterface $form_builder) {
    $this->formBuilder = $form_builder;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('form_builder')
    );
  }

  public function getFormId() {
    return 'prizma_combined_login_form';
  }

    public function buildForm(array $form, FormStateInterface $form_state) {

        $form['title'] = [
              '#type' => 'markup',
            '#markup' => '<h2>Iniciar sesión</h2>',
        ];

        $form['login'] = $this->formBuilder->getForm('Drupal\user\Form\UserLoginForm');

        $form['separator'] = [
            '#type' => 'markup',
            '#markup' => '<hr><p class="centered_prizma_login">Si es su primer inicio de sesión, o si olvido su contraseña, puede restablecerla aquí:</p>',
        ];

        $form['title2'] = [
              '#type' => 'markup',
            '#markup' => '<h2 class="centered_prizma_login">Resetear contraseña</h2>',
        ];

        $form['reset_password'] = $this->formBuilder->getForm('Drupal\user\Form\UserPasswordForm');
        $form['reset_password']['#attributes']['class'][] = 'my-custom-password-reset-class';

        $form['separator2'] = [
            '#type' => 'markup',
            '#markup' => '<hr>',
        ];
        return $form;
    }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    // No need to do anything here, as the individual forms will handle their own submission.
  }

}
