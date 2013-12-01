<?php
namespace Patrao\Model;

use Zend\Db\TableGateway\TableGateway;

class PatraoTable
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

	public function getPatrao($id)
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
	public function getPatraoByLogin($login)
	{
		//$id  = (int) $id;
		$rowset = $this->tableGateway->select(array('login' => $login));
		$row = $rowset->current();
		if (!$row) {
			throw new \Exception("Could not find row $login");
		}
		return $row;
	}

	public function savePatrao(Patrao $patrao)
	{
		$data = array(
				'nome' => $patrao->nome,
				'telefone'  => $patrao->telefone,
				'login'  => $patrao->login,
				'senha'  => $patrao->senha,
				'casa'  => $patrao->casa,
		);

		$id = (int)$patrao->id;
		if ($id == 0) {
			$this->tableGateway->insert($data);
		} else {
			if ($this->getPatrao($id)) {
				$this->tableGateway->update($data, array('id' => $id));
			} else {
				throw new \Exception('Form id does not exist');
			}
		}
	}

	public function deletePatrao($id)
	{
		$this->tableGateway->delete(array('id' => $id));
	}
}