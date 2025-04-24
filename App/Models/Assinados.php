<?php

namespace App\Models;

use MF\Model\Model;

class Assinados extends Model
{
    //Propostas assinadas mostrada em /assinados
    public function pegarPropostaAssinadasInicio()
    {
        $query = "SELECT 
       a.nome AS nome_associado,
       o.nome AS nome_praca,
       p.id_proposta, p.num_proposta
       FROM propostas AS p
       LEFT JOIN associados AS a ON (a.id_associado = p.id_associado)
       INNER JOIN origem AS o ON (o.cod_local = p.cod_local)
       WHERE p.status_proposta = 7
       AND a.inativo = 0
       ORDER BY p.data_proposta ASC
       LIMIT 20";

        $resultado = $this->db->query($query)->fetchAll(\PDO::FETCH_ASSOC);

        // Aplique a função statusPropostas() a cada item no $resultado
        array_walk($resultado, function (&$propostas) {
            $propostas['status'] = $this->statusPropostasAssinado();
        });

        return $resultado;
    }

    public function statusPropostasAssinado()
    {
        return "<span class='badge' style='background-color: #E0F2FE; color: #075985; border: 1px solid #E0F2FE'>
                   <i class='fas fa-file-signature mr-2' style='font-size: 14px;'></i>
                       ASSINADO
               </span>";
    }
}
