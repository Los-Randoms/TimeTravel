<?php namespace Modules\Kernel;

use Modules\Mysql\Utils;

class Entity {
	const TABLE = self::TABLE;
	public int $id;
	
	function save() {
		/** @var \Modules\Mysql\Driver */
		$driver = Storage::driver();
		$insert = $driver->create(static::TABLE);
		unset($this->id);
		foreach($this as $key => &$value)
			$insert->set($key, $value, Utils::valueType($value));
		$insert->execute();
		$this->id = $insert->insertId();
	}

	function update() {
		/** @var \Modules\Mysql\Driver */
		$driver = Storage::driver();
		$update = $driver->update(static::TABLE);
		foreach($this as $key => &$value)
			$update->set($key, $value, Utils::valueType($value));
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
		/** @var \Modules\Mysql\Driver */
		$driver = Storage::driver();
		$select = $driver->read(static::TABLE);
		foreach($ids as $id)
			$select->condition('id', $id, 'i', '=', 'OR');
		$select->execute();
		return $select->results(static::class);
	}

	static function remove(int $id) {
		/** @var \Modules\Mysql\Driver */
		$driver = Storage::driver();
		$delete = $driver->delete(static::TABLE);
		$delete->condition('id', $id);
		$delete->execute();
	}
}

