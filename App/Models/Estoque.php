<?php

namespace App\Models;

use MF\Model\Model;

class Estoque extends Model
{

    public function __get($atributo)
    {
        return $this->$atributo;
    }

    public function __set($atributo, $valor)
    {
        $this->$atributo = $valor;
    }
    //BUSCA OS ASSOCIADOS PARA MOSTRAR A TABELA DE ESTOQUE DELE.
    public function buscarEstoqueAssociado($num_proposta)
    {
        $query = "SELECT id_estoque, nome, cpf, num_proposta, valor_nominal, valor_presente, data_vencimento, situacao, data_upload
        FROM estoque
        WHERE num_proposta LIKE :num_proposta
        ORDER BY data_vencimento ASC";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':num_proposta', '%' . $num_proposta . '%');
        $stmt->execute();
        $resultado = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $resultado;
    }
    
    public function dadosQuitacao()
    {
        $query = "SELECT nome, cpf, num_proposta, valor_nominal, valor_presente, data_vencimento, situacao, data_upload
        FROM estoque
        WHERE num_proposta LIKE :num_proposta
        ORDER BY data_vencimento ASC";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':num_proposta', '%' . $this->__get('num_proposta') . '%');
        $stmt->execute();
        $resultado = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $resultado;
    }

    // Função para inserir registros no banco de dados
    public function inserirRegistros($registros)
    {
        // Monta a consulta de inserção em lote
        $query = "INSERT INTO `estoque_novo` (nome, cpf, num_proposta, data_aquisicao, situacao, valor_nominal, valor_presente, valor_aquisicao, data_vencimento) VALUES " . implode(',', $registros);
        $stmt = $this->db->prepare($query);

        $resultado = $stmt->execute();

        if (!$resultado) {
            echo "Erro ao inserir registros:";
        }
    }
    public function dropAlterTabelaEstoque($querySQL)
    {
            $query = $querySQL;
            $this->db->exec($query);
    }

    public function criarTabelaEstoque()
    {
        $query = "CREATE TABLE `estoque_novo` (
            `id_estoque` int(11) NOT NULL AUTO_INCREMENT,
            `nome` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
            `cpf` varchar(14) COLLATE utf8mb4_unicode_ci NOT NULL,
            `num_proposta` varchar(50) NOT NULL,
            `data_aquisicao` date NOT NULL,
            `situacao` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
            `valor_nominal` decimal(10,2) NOT NULL,
            `valor_presente` decimal(10,2) NOT NULL,
            `valor_aquisicao` decimal(10,2) NOT NULL,
            `data_vencimento` date NOT NULL,
            `data_upload` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (`id_estoque`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";

        $stmt = $this->db->prepare($query);
        $resultado = $stmt->execute();
        return $resultado;
    }
}
