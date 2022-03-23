<?php namespace Core\mysql\part;


class Values {
    private string $values = '';

    public function add(string $column, mixed $value) {
       $this->values .= "$column = $value, ";
    }

    public function __toString(): string {
       return substr($this->values, 0, -2);
    }
}

