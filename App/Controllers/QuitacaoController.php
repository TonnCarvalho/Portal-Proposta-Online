<?php

namespace App\Controllers;

use MF\Controller\Action;
use MF\Model\Container;

class QuitacaoController extends Action
{
  
  public function AutenticarUsuario()
	{
		$authController = new AuthController;
		return $authController->validarAutenticacao();
	}
    
  public function gerarArquivoQuitacao()
  {

    $estoqueModel = Container::getModel('Estoque');

    $num_proposta = $_POST['num_proposta'];

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && strlen($num_proposta)  > 7) {
      //TODO melhorar validação, impedir que não gerar o arquivo se o não encontrar o numero da proposta.
      $estoqueModel->__set('num_proposta', $num_proposta);
      $getDadosQuitacao = $estoqueModel->dadosQuitacao();

      //nome do arquivo
      $arquivo = 'arquivo.xls';
      //variavel para imprimir o nome e cpf apenas uma vez.
      $impresso = false;

      //tabela
      $html = "<table>
        <thead>
      <tr>
        <th>NOME</th>
        <th>CPF</th>
        <th>SEU_NUMERO</th>
        <th>QUITACAO FIDC</th>
      </tr>
        </thead>
      <tbody>";
      $somarQuitacao = 0;
      foreach ($getDadosQuitacao as $associado) {
        $html .= "<tr>";
        if (!$impresso) {
          $html .= "<td>{$associado['nome']}</td>
        <td>{$associado['cpf']}</td>";
          $impresso = true;
        } else {
          $html .= "<td></td>
            <td></td>";
        }
        $html .= "<td>{$associado['num_proposta']}</td>
        <td>
        " . number_format($associado['valor_presente'], 2, ',', '.') . "
        </td>
        </tr>";
        $somarQuitacao += $associado['valor_presente'];
      }
      $html .= "<tr>
      <td colspan='2'></td>
      <th style='text-align: right;'>SALDO FIDC</th>
      <th style='text-align: right;'>
      " . number_format($somarQuitacao, 2, ',', '.') . "
      </th>
      </tr>
        </tbody>
      </table>";


      // Configurações header para forçar o download
      header("Cache-Control: no-cache, must-revalidate");
      header("Pragma: no-cache");
      header("Content-type: application/x-msexcel");
      header("Content-Disposition: attachment; filename=\"{$arquivo}\"");
      header("Content-Description: PHP Generated Data");

      //enviar conteúdo
      echo $html;
      exit;
    } else {
      header('Location: /estoque-consulta');
    }
  }
}
