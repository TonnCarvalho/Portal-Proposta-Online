<?php

namespace App\Models;

use MF\Model\Model;

class Usuario extends Model
{

    public function __get($atributo)
    {
        return $this->$atributo;
    }

    public function __set($atributo, $valor)
    {
        $this->$atributo = $valor;
    }

    /**
     * Autentica o usuario ao fazer o login no sistema
     * @return usuario
     */
    public function autenticar()
    {
        $query = "SELECT id_usuario, cod_corretor, nome, atualizado, inativo, admin, nivel
        FROM usuarios
        WHERE cod_corretor = :cod_corretor
        AND senha = :senha";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':cod_corretor', $this->__get('cod_corretor'));
        $stmt->bindValue(':senha', $this->__get('senha'));
        $stmt->execute();

        $usuario = $stmt->fetch(\PDO::FETCH_ASSOC);

        //Verifica se existe o id e o nome do usuario
        if ($usuario['id_usuario'] != '' && $usuario['nome'] != '') {
            $this->__set('id_usuario', $usuario['id_usuario']);
            $this->__set('nome', $usuario['nome']);
            $this->__set('atualizado', $usuario['atualizado']);
            $this->__set('inativo', $usuario['inativo']);
            $this->__set('admin', $usuario['admin']);
            $this->__set('nivel', $usuario['nivel']);
        }

        return $this;
    }

    public function listaUsuario()
    {
        $query = "SELECT * 
        FROM usuarios
        ORDER BY cod_corretor ASC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        $resultado = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $resultado;
    }

    public function pesquisaUsuario()
    {
        $query = "SELECT *
        FROM usuarios
        WHERE cod_corretor LIKE :cod_corretor
        OR nome LIKE :nome
        ORDER BY cod_corretor ASC";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':cod_corretor', '%' . $this->__get('pesquisa') . '%');
        $stmt->bindValue(':nome', '%' . $this->__get('pesquisa') . '%');
        $stmt->execute();
        $resultado = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return $resultado;
    }

    public function mudarSituacaoUsuario()
    {
        $query = "UPDATE usuarios
        SET inativo = :inativo
        WHERE id_usuario = :id_usuario";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':inativo', $this->__get('inativo'));
        $stmt->bindValue(':id_usuario', $this->__get('id_usuario'));

        $stmt->execute();

        return $this;
    }

    public function adicionaUsuario()
    {
        $query = "INSERT INTO usuarios
        (cod_corretor, nome, cpf, email, tel, cel, cidade, uf, senha, nivel)
        VALUE 
        (:cod_corretor, :nome, :cpf, :email, :tel, :cel, :cidade, :uf, :senha, :nivel)";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':cod_corretor', $this->__get('cod_corretor'));
        $stmt->bindValue(':nome', $this->__get('nome'));
        $stmt->bindValue(':cpf', $this->__get('cpf'));
        $stmt->bindValue(':email', $this->__get('email'));
        $stmt->bindValue(':tel', $this->__get('tel'));
        $stmt->bindValue(':cel', $this->__get('cel'));
        $stmt->bindValue(':cidade', $this->__get('cidade'));
        $stmt->bindValue(':uf', $this->__get('uf'));
        $stmt->bindValue(':senha', $this->__get('senha'));
        $stmt->bindValue(':nivel', $this->__get('nivel'));

        $stmt->execute();

        return $this;
    }

    public function editaUsuario()
    {
        $query = "UPDATE usuarios
        SET 
        cod_corretor =  :cod_corretor,
        nome = :nome,
        cpf = :cpf,
        email = :email,
        tel = :tel,
        cel = :cel,
        cidade = :cidade,
        uf = :uf,
        nivel = :nivel
        WHERE id_usuario = :id_usuario";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':cod_corretor', $this->__get('cod_corretor'));
        $stmt->bindValue(':nome', $this->__get('nome'));
        $stmt->bindValue(':cpf', $this->__get('cpf'));
        $stmt->bindValue(':email', $this->__get('email'));
        $stmt->bindValue(':tel', $this->__get('tel'));
        $stmt->bindValue(':cel', $this->__get('cel'));
        $stmt->bindValue(':cidade', $this->__get('cidade'));
        $stmt->bindValue(':uf', $this->__get('uf'));
        $stmt->bindValue(':nivel', $this->__get('nivel'));
        $stmt->bindValue(':id_usuario', $this->__get('id_usuario'));
        $stmt->execute();

        return $this;
    }

    public function alteraSenhaUsuario()
    {
        $query = "UPDATE usuarios
        SET 
        senha = :senha
        WHERE id_usuario = :id_usuario";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':senha', $this->__get('senha'));
        $stmt->bindValue(':id_usuario', $this->__get('id_usuario'));
        $stmt->execute();

        return $this;
    }

    public function enviarRecuperarSenha()
    {
        $query = "INSERT INTO recuperar_senha (email, token) VALUES (:email, :token)";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':email', $this->__get('email'));
        $stmt->bindValue(':token', $this->__get('token'));
        $stmt->execute();
        return $this;
    }

    public function verificaDadosUsuario($select, $where, $value)
    {
        $query = "SELECT $select
        FROM usuarios
        WHERE $where = '$value'";

        $stmt = $this->db->prepare($query);
        $stmt->execute();

        $resultado = $stmt->fetchColumn();
        return $resultado;
    }

    public function loginAtualizarUsuario()
    {
        $query = "UPDATE usuarios
        SET 
        nome = :nome,
        cpf = :cpf,
        email = :email,
        cel = :cel,
        cidade = :cidade,
        uf = :uf,
        atualizado = :atualizado
        WHERE id_usuario = :id_usuario";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':nome', $this->__get('nome'));
        $stmt->bindValue(':cpf', $this->__get('cpf'));
        $stmt->bindValue(':email', $this->__get('email'));
        $stmt->bindValue(':cel', $this->__get('cel'));
        $stmt->bindValue(':cidade', $this->__get('cidade'));
        $stmt->bindValue(':uf', $this->__get('uf'));
        $stmt->bindValue(':atualizado',  $this->__get('atualizado'));
        $stmt->bindValue(':id_usuario', $this->__get('id_usuario'));
        $stmt->execute();

        return $this;
    }

    public function loginDadosUsuario($id_usuario)
    {
        $query = "SELECT nome, cpf, cel, email, uf, cidade
        FROM usuarios
        WHERE id_usuario = '$id_usuario'";

        $stmt = $this->db->prepare($query);
        $stmt->execute();

        $resultado = $stmt->fetch();
        return $resultado;
    }

    public function verificaEmail()
    {
        $query = "SELECT email
        FROM usuarios
        WHERE email = :email";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':email', $this->__get('email'));
        $stmt->execute();

        $resultado = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $resultado;
    }

    public function ultimoLogin()
    {
        $query = "UPDATE usuarios
        SET 
        ultimo_login = :ultimo_login
        WHERE id_usuario = :id_usuario";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':ultimo_login', $this->__get('ultimo_login'));
        $stmt->bindValue(':id_usuario', $this->__get('id_usuario'));
        $stmt->execute();

        return $this;
    }
}
