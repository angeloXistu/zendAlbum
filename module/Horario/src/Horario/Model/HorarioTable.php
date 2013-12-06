<?php
namespace Horario\Model;

use Zend\Db\TableGateway\TableGateway;

class HorarioTable
{
	protected $tableGateway;

	public function __construct(TableGateway $tableGateway)
	{
		$this->tableGateway = $tableGateway;
	}

	public function fetchAll()
	{
		$resultSet = $this->tableGateway->select();
		return $resultSet;
	}

	public function getHorario($id)
	{
		$id  = (int) $id;
		$rowset = $this->tableGateway->select(array('id' => $id));
		$row = $rowset->current();
		if (!$row) {
			throw new \Exception("Could not find row $id");
		}
		return $row;
	}
	
	/*
	 * Funcao que recebe por parametro o login do sugeito e retorna os dados dele.
	 */
	public function getHorariosByLoginFuncionario($login)
	{
		$rowset = $this->tableGateway->select(array('fk_funcionario' => $login));
		//var_dump($rowset);
		$row = $rowset->current();
		//var_dump($rowset);
		if (!$row) {
			return null;
		}
		return $row;
		/*
		$sql = new Sql($this->adapter);
		$select = $sql->select();
		$select->from($this->table)
		->join('album', 'tracks.album_id = album.id');
		
		$where = new  Where();
		$where->equalTo('album_id', $id) ;
		$select->where($where);
		
		//you can check your query by echo-ing :
		// echo $select->getSqlString();
		$statement = $sql->prepareStatementForSqlObject($select);
		$result = $statement->execute();
		
		return $result;
		*/
	}
	public function getHorarioByLoginPatrao($login)
	{
		//$id  = (int) $id;
		$rowset = $this->tableGateway->select(array('fk_patrao' => $login));
		$row = $rowset->current();
		if (!$row) {
			return null;
		}
		return $row;
	}
	public function saveHorario(Horario $horario)
	{
		$data = array(
				'entrada' => $horario->entrada,
				'saida'  => $horario->saida,
				'fk_patrao'  => $horario->fk_patrao,
				'fk_funcionario'  => $horario->fk_funcionario,
				'data'  => $horario->data,
		);

		$id = (int)$horario->id;
		if ($id == 0) {
			$this->tableGateway->insert($data);
		} else {
			if ($this->getHorario($id)) {
				$this->tableGateway->update($data, array('id' => $id));
			} else {
				throw new \Exception('Form id does not exist');
			}
		}
	}

	public function deleteHorario($id)
	{
		$this->tableGateway->delete(array('id' => $id));
	}
}