<?php namespace Core\mysql\part;

class Columns {
   private string $columns = '';

   public function add(string $column) {
      $this->columns .= "$column, ";
   }

   public function __toString(): string {
      $values = substr($this->columns, 0, -2);
      return empty($values)? '*' : $values;
   }
}
