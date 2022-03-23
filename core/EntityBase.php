<?php namespace Core;

abstract class EntityBase {
	public int $id = 0;
	abstract static function table(): string;

	public function isNew(): bool {
		return $this->id === 0;
	}
}

