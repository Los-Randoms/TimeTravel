<?php namespace Core\mysql\enums;

use Core\utils\Enum;

class Operators extends Enum {
   static bool $valid_name = true;
   const AND = '&&';
   const OR = '||';
}


