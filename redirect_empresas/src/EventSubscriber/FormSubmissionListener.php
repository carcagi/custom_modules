<?php

namespace Drupal\redirect_empresas\EventSubscriber;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Mail\MailManagerInterface;
use Drupal\webform\Event\WebformSubmissionFormEntityEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Listens to webform submission events.
 */
class FormSubmissionListener implements EventSubscriberInterface {

  /**
   * The entity type manager service.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * The mail manager service.
   *
   * @var \Drupal\Core\Mail\MailManagerInterface
   */
  protected $mailManager;

  /**
   * Constructs a new FormSubmissionListener object.
   *
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entityTypeManager
   *   The entity type manager service.
   * @param \Drupal\Core\Mail\MailManagerInterface $mailManager
   *   The mail manager service.
   */
  public function __construct(EntityTypeManagerInterface $entityTypeManager, MailManagerInterface $mailManager) {
    $this->entityTypeManager = $entityTypeManager;
    $this->mailManager = $mailManager;
  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    return [
      'webform_submission.insert' => 'onFormSubmission',
    ];
  }

  /**
   * Handles the webform submission event.
   *
   * @param \Drupal\webform\Event\WebformSubmissionFormEntityEvent $event
   *   The webform submission event.
   */
  public function onFormSubmission(WebformSubmissionFormEntityEvent $event) {
    \Drupal::logger('redirect_empresas')->notice('onFormSubmission called');
    // Obtener los datos del formulario de la presentación.
    $submission = $event->getSubmission();
    $data = $submission->getData();

    // Verificar si el formulario es el que necesitas (por ejemplo, usando el webform_id).
    $webform_id = 'empresas';
    if ($submission->getWebform()->id() === $webform_id) {
      // Obtener el correo electrónico proporcionado por el usuario.
      $correo_electronico = $data['correo_electronico_'];

      // Verificar si ya existe un usuario con el mismo correo electrónico.
      $user = user_load_by_mail($correo_electronico);
      if (!$user) {
        // Crear el usuario con el rol "empresa".
        $user = $this->entityTypeManager->getStorage('user')->create([
          'name' => $correo_electronico,
          'mail' => $correo_electronico,
          'status' => 1,
          'roles' => ['empresa'],
        ]);
        $user->save();

        // Enviar el correo electrónico con el enlace para establecer la contraseña.
        $params = ['user' => $user];
        $this->mailManager->mail('redirect_empresas', 'user_register', $correo_electronico, $language, $params, NULL, TRUE);
      }
    }
  }

}
