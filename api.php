<?php

class API
{
	private $connect = '';
	
	function __construct()
	{
		$this->database_connection();
	}
	
	function database_connection()
	{
		$this->connect = new PDO("mysql:host=localhost;dbname=crud", "crud", "crud");
	}
	
	function fetch_all()
	{
		$query = "SELECT * FROM voluntario ORDER BY id";
		$statement = $this->connect->prepare($query);
		if($statement->execute())
		{
			while($row = $statement->fetch(PDO::FETCH_ASSOC))
			{
				$data[] = $row;
			}
			return $data;
		}
	}
	
	function delete($id)
	{
		$query = "DELETE FROM voluntario WHERE id = '".$id."'";
		$statement = $this->connect->prepare($query);
		if($statement->execute())
		{
			$data[] = array(
				'success' => '1'
			);
		}
		else
		{
			$data[] = array(
				'success' => '0'
			);
		}
		return $data;
	}
	
	function insert()
	{
		if(isset($_POST["nome"]))
		{
			$form_data = array(
			':nome'  => $_POST["nome"],
			':area'  => $_POST["area"]
			);
			$query = "
			INSERT INTO voluntario 
			(nome, area) VALUES 
			(:nome, :area)
			";
			$statement = $this->connect->prepare($query);
			if($statement->execute($form_data))
			{
				$data[] = array(
				'success' => '1'
				);
			}
			else
			{
				$data[] = array(
				'success' => '0'
				);
			}
		}
		else
		{
			$data[] = array(
			'success' => '0'
			);
		}
		return $data;
	}
	
	function fetch_single($id)
	{	
		$query = "SELECT * FROM voluntario WHERE id='".$id."'";
		$statement = $this->connect->prepare($query);
		if($statement->execute())
		{
			foreach($statement->fetchAll() as $row)
			{
			$data['nome'] = $row['nome'];
			$data['area'] = $row['area'];
			}
			return $data;
		}
	}
	
	function update()
	{
		if(isset($_POST["nome"]))
		{
			$form_data = array(
			':nome' => $_POST['nome'],
			':area' => $_POST['area'],
			':id'   => $_POST['id']
			);
			$query = "
			UPDATE voluntario 
			SET nome = :nome, area = :area 
			WHERE id = :id
			";
			$statement = $this->connect->prepare($query);
			if($statement->execute($form_data))
			{
				$data[] = array(
					'success' => '1'
				);
			}
			else
			{
				$data[] = array(
					'success' => '0'
				);
			}
		}
		else
		{
			$data[] = array(
			'success' => '0'
			);
		}
		return $data;
	}

}

?>