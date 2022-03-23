<?php namespace Core\mysql\query;

use Core\mysql\Database;
use mysqli_result;

abstract class Query {
	protected string $data_types = '';
	protected array $data_values = [];

	public function execute(): mysqli_result {
		$db = Database::instance();
		$stmt = $db->prepare($this->__toString());
		$stmt->bind_param($this->data_types, ...$this->data_values);
		$stmt->execute();
		return $stmt->get_result();
	}

	abstract public function __toString(): string;
}
