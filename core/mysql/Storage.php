<?php namespace Core\mysql;

use Core\EntityBase;
use Core\mysql\query\Delete;
use Core\mysql\query\Insert;
use Core\mysql\query\Select;
use Core\mysql\query\Update;
use ReflectionClass;
use Error;

class Storage {
	private string $T;
	private string $table;
	

	public function __construct(Database $db, string $T) {
		$refl = new ReflectionClass($T);
		if(!$refl->isSubclassOf(EntityBase::class))
			throw new Error("$T is not sublcass of EntityBase");

		$this->db = $db;
		$this->T = $T;
		$this->table = $T::table();
	}

	public function save(object $entity) {
		$query = new Insert($this->table);

		if(!($entity instanceof $this->T))
			throw new Error("Entity is not of type {$this->T}");

		unset($entity->id);
		foreach($entity as $param => $value)
			$query->set($param, $value);
		$query->execute();
	}

	public function get(int $id): ?object {
		$query = new Select($this->table);
		$query->condition('id', $id);
		$result = $query->execute();
		return $result->fetch_object($this->T);
	}

	public function getAll(int ...$ids): array {
		$query = new Select($this->table);
		foreach($ids as $id) 
			$query->condition('id', $id);
		$result = $query->execute();
		$rows = [];
		while($row = $result->fetch_object($this->T))
			$rows = $row;
		return $rows;
	}

	public function update(EntityBase $entity) {
		$query = new Update($this->table);
		$id = $entity->id;
		unset($entity->id);
		foreach($entity as $param => $value)
			$query->set($param, $value);
		$query->condition('id', $id);
		$query->execute();
	}

	public function delete(int $id) {
		$query = new Delete($this->table);
		$query->condition('id', $id);
		$query->execute();
	}
}
