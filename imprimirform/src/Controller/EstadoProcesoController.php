<?php

namespace Drupal\imprimirform\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\webform\Entity\WebformSubmission;
use Drupal\Core\Url;
use Drupal\Core\Link;

class EstadoProcesoController extends ControllerBase {

  public function content() {
    $user = \Drupal::currentUser();
    $webform_id = 'formulario_de_vinculacion_person';

    // Verificar si el usuario ha enviado el formulario.
    $submission = $this->getWebformSubmission($user->id(), $webform_id);
    // Si el usuario ha enviado el formulario, mostrar enlace a la vista de respuestas.
    $url = '';
    $data = [];
    if ($submission) {
      $data['subir_link'] = '/subir-documento';
      $data['prev_url'] = '/respuestas/' . $submission->id();

    }

    $url = "/formulario-empresas";
    $data['form_submitted'] = ($submission !== NULL);
    $data['url'] = $url;
    $build = [
        '#theme' => 'imprimirform_estado_proceso',
        '#datos' => $data,
        '#attached' => [
            'library' => [
                'imprimirform/imprimirform_styles',
            ],
        ],
    ];
    return $build;

  }

  private function getWebformSubmission($user_id, $webform_id) {
    // Crea una instancia de la entidad de consulta para la presentación de webform.
    $query = \Drupal::entityQuery('webform_submission')
      ->condition('webform_id', $webform_id)
      ->condition('uid', $user_id)
      ->sort('completed', 'DESC') // Ordenar por la fecha de completado (envío).
      ->range(0, 1);

    // Agrega la opción de verificación de acceso a la consulta.
    $query->accessCheck(TRUE);

    // Ejecuta la consulta y obtén los IDs de las presentaciones.
    $submission_ids = $query->execute();

    if (!empty($submission_ids)) {
      $submission_id = reset($submission_ids);
      $submission = WebformSubmission::load($submission_id);
      return $submission;
    }

    return NULL;
  }

}
