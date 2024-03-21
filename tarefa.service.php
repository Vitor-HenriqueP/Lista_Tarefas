<?php

class TarefaService {

    private $conexao;
    private $tarefa;

    public function __construct(Conexao $conexao, Tarefa $tarefa) {
        $this->conexao = $conexao->conectar();
        $this->tarefa = $tarefa;
    }

    public function inserir() {
        $query = 'insert into tb_tarefas(tarefa) values(:tarefa)';
        $stmt = $this->conexao->prepare($query);
        $stmt->bindValue(':tarefa', $this->tarefa->__get('tarefa'));
        $stmt->execute();
    }

	public function recuperar() {
		$query = '
			SELECT 
				t.id, s.status, t.tarefa 
			FROM 
				tb_tarefas AS t
				LEFT JOIN tb_status AS s ON (t.id_status = s.id)
			ORDER BY
				t.data_cadastrado DESC
		';
		$stmt = $this->conexao->prepare($query);
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_OBJ);
	}
	
	
	

    public function atualizar() {
        $query = "update tb_tarefas set tarefa = ? where id = ?";
        $stmt = $this->conexao->prepare($query);
        $stmt->bindValue(1, $this->tarefa->__get('tarefa'));
        $stmt->bindValue(2, $this->tarefa->__get('id'));
        return $stmt->execute(); 
    }

    public function remover() {
        $query = 'delete from tb_tarefas where id = :id';
        $stmt = $this->conexao->prepare($query);
        $stmt->bindValue(':id', $this->tarefa->__get('id'));
        $stmt->execute();
    }

    public function marcarRealizada() {
        $query = "update tb_tarefas set id_status = ? where id = ?";
        $stmt = $this->conexao->prepare($query);
        $stmt->bindValue(1, $this->tarefa->__get('id_status'));
        $stmt->bindValue(2, $this->tarefa->__get('id'));
        return $stmt->execute(); 
    }

    public function recuperarTarefasPendentes($ordenacao = null) {
		$query = '
			select 
				t.id, s.status, t.tarefa 
			from 
				tb_tarefas as t
				left join tb_status as s on (t.id_status = s.id)
			where
				t.id_status = :id_status
		';
	
		if ($ordenacao != null) {
			$query .= ' order by ';
	
			switch ($ordenacao) {
				case 'nome_asc':
					$query .= 't.tarefa asc';
					break;
				case 'data_cadastrado_desc':
					// Corrigindo para usar a coluna correta: data_cadastro
					$query .= 't.data_cadastrado desc';
					break;
				default:
					// Opção padrão, ordenar por nome ascendente
					$query .= 't.tarefa asc';
			}
		}
	
		$stmt = $this->conexao->prepare($query);
		$stmt->bindValue(':id_status', 1);
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_OBJ);
	}
	
	
}

?>
