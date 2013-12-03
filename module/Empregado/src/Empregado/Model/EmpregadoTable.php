<?php
namespace Empregado\Model;

use Zend\Db\TableGateway\TableGateway;

class EmpregadoTable
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

	public function getEmpregado($id)
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
	public function getEmpregadoByLogin($login)
	{
		//$id  = (int) $id;
		$rowset = $this->tableGateway->select(array('login' => $login));
		$row = $rowset->current();
		if (!$row) {
			throw new \Exception("Could not find row $login");
		}
		return $row;
	}

	public function saveEmpregado(Empregado $empregado)
	{
		$data = array(
				'nome' => $empregado->nome,
				'telefone'  => $empregado->telefone,
				'login'  => $empregado->login,
				'senha'  => $empregado->senha,
				'loginp'  => $empregado->loginp,
		);

		$id = (int)$empregado->id;
		if ($id == 0) {
			$this->tableGateway->insert($data);
		} else {
			if ($this->getEmpregado($id)) {
				$this->tableGateway->update($data, array('id' => $id));
			} else {
				throw new \Exception('Form id does not exist');
			}
		}
	}

	public function deleteEmpregado($id)
	{
		$this->tableGateway->delete(array('id' => $id));
	}
}