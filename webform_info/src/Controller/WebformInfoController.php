<?php // Nunca deve ser informado o fechamento do bloco de código PHP.

/**
 * Exemplo de módulo que acessa informações submetidas em um webform.
 */

// Caminho para a pasta Controller
namespace Drupal\webform_info\Controller;

// É preciso adicionar os aqui as classes que precisarão ser utilizadas/
use Drupal\Core\Controller\ControllerBase;
use Drupal\webform\Entity\WebformSubmission;

// campo_webform e campo_webform_processamento são os nomes de máquina dos campos informados no webform
class WebformInfoController extends ControllerBase {
  /**
   * Retornar informações do form.
   *
   * @return array
   */
  // $webform_submission será a última coisa informada na URL, espera-se que seja um ID de um Webform.
  public function content($webform_submission) {
	// Podemos acessar as informações de qualquer entidade do Drupal dessa maneira, basta descobrirmos qual entidade é e utilizar a função load para carregar os dados.
    $webform_data = WebformSubmission::load($webform_submission)->getOriginalData();

	// Aqui vamos criar um array com as informações que queremos mostrar para o usuário.
	// Podemos criar quantas posições quisermos, os itens seráo renderizados na mesma ordem que informado no nosso $output.
    $output['message'] = [
      '#plain_text' => 'Informações do webform:'
    ];
	// Utilizando a propriedade '#markup', podemos adicionar quaisquer tags HTML da forma que quisermos.
    $output['content'] = [
      '#markup' => '<div>'. $webform_data['campo_webform'] . '</div>'
    ];

	// É possível acessar os valores do que for informado no drupalSettings diretamente dos arquivos javascript.
	// Neste caso acessamos da seguinte forma: drupalSettings.processamento
    $output['#attached']['drupalSettings']['processamento'] = $webform_data['campo_webform_processamento'];

	// Tudo que foi informado nos arrays será mostrado na página.
    return $output;
  }
}
