<?php

namespace App;

class Connection
{

	public static function getDb()
	{
		try {
			if ($_SERVER['HTTP_HOST'] == 'localhost:8080') {
				$conn = new \PDO(
					"mysql:host=localhost;
					dbname=propostaonline;
					charset=utf8mb4",
					"root",
					"",
				);
			}
			return $conn;
		} catch (\PDOException $e) {
			echo $e->getMessage();
			return 'Erro com o servidor';
		}
	}
}
