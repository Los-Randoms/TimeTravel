<?php namespace Modules\Mysql\Query;

use Modules\Kernel\Select as KernelSelect;
use Modules\Mysql\Query;
use Modules\Mysql\Traits\QueryConditionTrait;
use Modules\Mysql\Traits\QueryGroupTrait;
use Modules\Mysql\Traits\QueryLimitTrait;
use Modules\Mysql\Traits\QueryOrderTrait;
use Modules\Mysql\Traits\QuerySelectTrait;

class Select extends Query implements KernelSelect {
    use QuerySelectTrait;
    use QueryGroupTrait;
    use QueryLimitTrait;
    use QueryOrderTrait;
    use QueryConditionTrait;

	function execute(): bool {
		$this->exec($this->condTypes, $this->condValues);
		return true;
	}

    function __toString(): string {
        $query = "SELECT {$this->selectPart} FROM `{$this->table}`";
        if(!empty($this->condPart))
            $query .= " WHERE {$this->condPart}";
        if(!empty($this->groupPart))
            $query .= " GROUP BY {$this->groupPart}";
        if(!empty($this->orderPart))
            $query .= " ORDER BY {$this->orderPart}";
        if(isset($this->count))
            $query .= " LIMIT {$this->count} OFFSET {$this->offset}";
        return $query;
    }
}
