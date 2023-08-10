<?php

namespace Drupal\prizma_form_view\Controller;

use Drupal\Core\Controller\ControllerBase;

class PrizmaFormViewController extends ControllerBase {
    public function viewForm() {
    
        $webform = \Drupal::entityTypeManager()->getStorage('webform')->load('formulario_de_vinculacion_person');
        // Si la entidad Webform existe, obtén el formulario.
        if ($webform) {
            $form = \Drupal::entityTypeManager()->getViewBuilder('webform')->view($webform);
            return [
              '#theme' => 'prizma_form_view_form',
              '#form' => $form,
              '#attached' => [
                'library' => [
                  'prizma_form_view/form-styles',
                ],
              ],
            ];
        }
        // Si no se encuentra el Webform, muestra un mensaje de error.
        \Drupal::messenger()->addError(t('El formulario no se encuentra.'));
        return [];
    }
}
