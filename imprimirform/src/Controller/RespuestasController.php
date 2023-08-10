<?php
// modules/custom/imprimirform/src/Controller/RespuestasController.php
namespace Drupal\imprimirform\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\webform\Entity\WebformSubmission;

class RespuestasController extends ControllerBase {

    public function content($respuesta_id) {
      $data = $this->getRespuestas($respuesta_id);
      $data['fecha_diligenciamiento'] = $this->getFechaDiligenciamiento($respuesta_id);
      $build = [
        '#theme' => 'imprimirform_respuestas',
        '#datos' => $data,
        '#attached' => [
            'library' => [
                'imprimirform/imprimirform_styles',
            ],
        ],
      ];
      return $build;
    }

    private function getRespuestas($respuesta_id) {
      // Obtén la respuesta del webform usando el ID de la respuesta.
      $submission = WebformSubmission::load($respuesta_id);
      if ($submission) {
        // Obtén los datos de la respuesta.
        $data = $submission->getData();
        return $data;
      }
      // Si no se encontró la respuesta, devuelve un array vacío.
      return [];
    }

    private function getFechaDiligenciamiento($respuesta_id) {
        // Obtén la fecha de diligenciamiento de la respuesta del webform.
        $submission = WebformSubmission::load($respuesta_id);
        if ($submission) {
          // Obtén la fecha de la respuesta.
          $date = $submission->getCreatedTime();
          // Formatea la fecha en el formato "DD/MM/AAAA".
          $formatted_date = date('d/m/Y', $date);
          return $formatted_date;
        }
        // Si no se encontró la respuesta o no se pudo obtener la fecha, devuelve una cadena vacía.
        return '';
    }

  }
