<?php

namespace Drupal\prizma_login\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Form\FormBuilderInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a 'PrizmaLoginBlock' block.
 *
 * @Block(
 *  id = "prizma_login_block",
 *  admin_label = @Translation("Prizma login block"),
 * )
 */
class PrizmaLoginBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * Drupal\Core\Form\FormBuilderInterface definition.
   *
   * @var \Drupal\Core\Form\FormBuilderInterface
   */
  protected $formBuilder;

  /**
   * Constructs a new PrizmaLoginBlock object.
   */
  public function __construct(
    array $configuration,
    $plugin_id,
    $plugin_definition,
    FormBuilderInterface $form_builder
  ) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->formBuilder = $form_builder;
  }

  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('form_builder')
    );
  }

  /**
   * {@inheritdoc}
   */
    public function build() {
          $build = [];

          $login_form = $this->formBuilder->getForm('Drupal\user\Form\UserLoginForm');
          $password_form = $this->formBuilder->getForm('Drupal\user\Form\UserPasswordForm');

          $build['login_form'] = $login_form;
          $build['separator'] = [
            '#type' => 'markup',
            '#markup' => '<hr><p>Si es su primer inicio de sesión, u olvido su contraseña, puede restablecerla aquí:</p>',
          ];
          $build['password_form'] = $password_form;

          return $build;
    }



}
