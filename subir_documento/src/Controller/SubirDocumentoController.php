<?php

namespace Drupal\subir_documento\Controller;

use Drupal\Core\Controller\ControllerBase;

class SubirDocumentoController extends ControllerBase {

    public function viewForm() {

        $webform = \Drupal::entityTypeManager()->getStorage('webform')->load('subida_de_contrato_firmado');
        // Si la entidad Webform existe, obtén el formulario.
        if ($webform) {
            $form = \Drupal::entityTypeManager()->getViewBuilder('webform')->view($webform);
            return [
              '#theme' => 'subir_documento_form',
              '#form' => $form,
              '#attached' => [
                'library' => [
                  'subir_documento/form-styles',
                ],
              ],
            ];
        }
        // Si no se encuentra el Webform, muestra un mensaje de error.
        \Drupal::messenger()->addError(t('El formulario no se encuentra.'));
        return [];
    }



}
