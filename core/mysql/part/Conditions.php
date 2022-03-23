<?php namespace Core\mysql\part;

use Core\mysql\enums\Operators;

class Conditions {
   private string $conditions = '';

   public function add(string $condition, string $operator = Operators::AND) {
      $operator = new Operators($operator);
      if($this->conditions)
         $this->conditions .= " $operator ";
      $this->conditions .= $condition;
   }

   public function __toString(): string {
      return $this->conditions;
   }
}



