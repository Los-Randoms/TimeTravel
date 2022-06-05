<?php

namespace Modules\Kernel;

/**
 * Controller base for forms
 * */
abstract class Form extends Controller
{
	private string $method = 'POST';
	private array $fields = [];

	/**
	 * Create the form with 
	 * */
	protected function __construct(string $method, array $fields = [])
	{
		$this->method = strtoupper($method);
		$this->fields = $fields;
	}

	/**
	 * Initilize the controller, this checks 
	 * if the user has permissions and the user
	 * has POSTED data and check the fields
	 * specified 
	 * */
	function init()
	{
		# Check permissions
		parent::init();
		# Check form
		$method = strtoupper($_SERVER['REQUEST_METHOD']);
		if ($method === $this->method) {
			# Check fields and process data
			$data = [];
			foreach ($this->fields as $key => $field) {
				$from = $field['from'] ?? $_REQUEST;
				$value =  $from[$key] ?? null;
				# Trim the info
				if ($field['trim'] ?? false)
					$value = trim($value);
				# Set the data type
				if ($field['type'] ?? false)
					settype($value, $field['type']);
				# Pass the validation if the field is optional
				if (!($field['optional'] ?? false)) {
					if (!isset($value))
						return Message::add("Verifique la informacion");
					# Check length
					if(isset($field['length']) && !empty($field['length'])) {
						$len = $field['length'] ?? 0;
						if (!(mb_strlen($value) > $len))
							return Message::add("Verifique la informacion");
					}
					# Use filters
					if(isset($field['filter']) && !empty($field['filter'])) {
						$filter = $field['filter']['type'] ?? FILTER_DEFAULT;
						$options = $field['filter']['options'] ?? [];
						if (filter_var($value, $filter, $options) === false)
							return Message::add("Verifique la informacion");
					}
				}
				$data[$key] = $value;
			}

			# Verify info and if it does not return nothing then continue
			$validation = $this->verify($data);
			if (!empty($validation))
				return $this->submit($data);
			return $validation;
		}
	}

	/** 
	 * Check the form data integrity and return a response
	 * */
	abstract function verify(&$data);

	/** 
	 * Submit the data if the information provided was correct
	 * */
	abstract function submit(&$data);
}
