<?php namespace Modules\Kernel;

class Entity {
	const TABLE = self::TABLE;
	public int $id;
	
	function save() {
		/** @var \Modules\Mysql\Driver */
		$driver = Storage::driver();
		$insert = $driver->create(static::TABLE);
		unset($this->id);
		foreach($this as $k => &$v)
			$insert->set($k, $v);
		$insert->execute();
		$this->id = $insert->insertId();
	}

	function update() {
		/** @var \Modules\Mysql\Driver */
		$driver = Storage::driver();
		$update = $driver->update(static::TABLE);
		foreach($this as $k => &$v)
			$update->set($k, $v);
		$update->condition('id', $this->id);
		$update->execute();
	}

	static function load(int $id): ?static {
		/** @var \Modules\Mysql\Driver */
		$driver = Storage::driver();
		$select = $driver->read(static::TABLE);
		$select->condition('id', $id);
		$select->execute();
		$entity = $select->fetch(static::class);
		return $entity;
	}

	static function loadAll(int ...$ids): array {
		$rows = [];
		/** @var \Modules\Mysql\Driver */
		$driver = Storage::driver();
		$select = $driver->read(static::TABLE);
		if(count($ids) > 0) {
			$select->condition('id', $id);
			foreach($ids as $id) {
				$select->execute();
				$rows[] = $select->fetch(static::class);
			}
			return $rows;
		} else {
			$select->execute();
			$rows = $select->results(static::class);
			return $rows;
		}
	}

	static function remove(int $id) {
		/** @var \Modules\Mysql\Driver */
		$driver = Storage::driver();
		$delete = $driver->delete(static::TABLE);
		$delete->condition('id', $id);
		$delete->execute();
	}
}

