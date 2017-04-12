<?php
namespace MUMSched\Libraries;

class CustomValidator extends \Illuminate\Validation\Validator
{

	/**
	 * Magically adds validation methods.
	 * Normally the Laravel Validation methods
	 * only support single values to be validated like 'numeric', 'alpha', etc.
	 * Here we copy those methods to work also for arrays, so we can validate
	 * if a value is OR an array contains only 'numeric', 'alpha', etc. values.
	 *
	 * $rules = array(
	 * 'row_id' => 'required|integerOrArray', // "row_id" must be an integer OR
	 * an array containing only integer values
	 * 'type' => 'inOrArray:foo,bar' // "type" must be 'foo' or 'bar' OR an
	 * array containing nothing but those values
	 * );
	 *
	 * @param string $method
	 *        	Name of the validation to perform e.g. 'numeric', 'alpha',
	 *        	etc.
	 * @param array $parameters
	 *        	Contains the value to be validated, as well as additional
	 *        	validation information e.g. min:?, max:?, etc.
	 * @see http://stackoverflow.com/questions/18161785/validation-of-array-form-fields-in-laravel-4-error
	 */
	public function __call($method, $parameters)
	{

		// Convert method name to its non-array counterpart (e.g.
		// validateNumericArray converts to validateNumeric)
		if (substr($method, - 7) === 'OrArray')
			$method = substr($method, 0, - 7);

			// Call original method when we are dealing with a single value
			// only, instead of an array
		if (! is_array($parameters[1]))
			return call_user_func_array(array(
				$this,
				$method
			), $parameters);

		$success = TRUE;
		foreach ($parameters[1] as $value) {
			$parameters[1] = $value;
			$success &= call_user_func_array(array(
				$this,
				$method
			), $parameters);
		}

		return $success;
	}

	/**
	 * Al OrArray validation functions can use their non-array error message
	 * counterparts
	 *
	 * @param mixed $attribute
	 *        	The value under validation
	 * @param string $rule
	 *        	Validation rule
	 * @see http://stackoverflow.com/questions/18161785/validation-of-array-form-fields-in-laravel-4-error
	 */
	protected function getMessage($attribute, $rule)
	{
		if (substr($rule, - 7) === 'OrArray') {
			$rule = substr($rule, 0, - 7);
		}

		return parent::getMessage($attribute, $rule);
	}

	/**
	 * Valida campo CPF
	 *
	 * @param unknown $attribute
	 * @param unknown $value
	 * @param unknown $parameters
	 * @return boolean
	 * @access public
	 * @author William Ochetski Hellas
	 */
	public function validateCpf($attribute, $value, $parameters)
	{
		$nulos = array(
			'01234567890',
			'12345678909',
			'11111111111',
			'22222222222',
			'33333333333',
			'44444444444',
			'55555555555',
			'66666666666',
			'77777777777',
			'88888888888',
			'99999999999',
			'00000000000'
		);
		// check format
		if (! preg_match('~^([0-9]{11}|[0-9]{3}\.[0-9]{3}\.[0-9]{3}\-[0-9]{2})$~i', $value)) {
			return FALSE;
		}
		// clean non numeric
		$value = preg_replace('~[^0-9]+~', '', $value);
		// returns false if it's null
		if (in_array($value, $nulos)) {
			return FALSE;
		}
		// calculate the penultimate verificator digit
		$acum = 0;
		for ($i = 0; $i < 9; $i++) {
			$acum += $value{$i} * (10 - $i);
		}
		$x = $acum % 11;
		$acum = ($x > 1) ? (11 - $x) : 0;
		// returns false if calculated digit is invalid
		if ($acum != $value{9}) {
			return FALSE;
		}
		// calculate the last verificator digit
		$acum = 0;
		for ($i = 0; $i < 10; $i++) {
			$acum += $value{$i} * (11 - $i);
		}
		$x = $acum % 11;
		$acum = ($x > 1) ? (11 - $x) : 0;
		// returns false if calculated digit is invalid
		if ($acum != $value{10}) {
			return FALSE;
		}
		return $value;
	}

	/**
	 * Resolve mensagem do campo CPF
	 *
	 * @param unknown $message
	 * @param unknown $attribute
	 * @param unknown $rule
	 * @param unknown $parameters
	 * @return string
	 * @access public
	 * @author William Ochetski Hellas
	 */
	protected function replaceCPF($message, $attribute, $rule, $parameters)
	{
		if (count($parameters) > 0)
			return str_replace(':cpf', $parameters, $message);
		else
			return $message;
	}

	/**
	 * Valida campo CNPJ
	 *
	 * @param unknown $attribute
	 * @param unknown $value
	 * @param unknown $parameters
	 * @return boolean
	 * @access public
	 * @author William Ochetski Hellas
	 */
	public function validateCnpj($attribute, $value, $parameters)
	{
		// check format (xx.xxx.xxx/xxxx-xx or 14 digits)
		if (! preg_match('~^([0-9]{14}|[0-9]{2,3}\.[0-9]{3}\.[0-9]{3}\/[0-9]{4}\-[0-9]{2})$~i', $value)) {
			return false;
		}

		// clean non numeric
		$value = preg_replace('/[^0-9]/si', '', $value);

		// calculate the penultimate verificator digit
		$sum1 = ($value{0} * 5) + ($value{1} * 4) + ($value{2} * 3) + ($value{3} * 2) + ($value{4} * 9) + ($value{5} * 8) + ($value{6} * 7) + ($value{7} * 6) + ($value{8} * 5) + ($value{9} * 4) + ($value{10} * 3) + ($value{11} * 2);
		$last = $sum1 % 11;
		$digit1 = $last < 2 ? 0 : 11 - $last;

		// calculate the last verificator digit
		$sum2 = ($value{0} * 6) + ($value{1} * 5) + ($value{2} * 4) + ($value{3} * 3) + ($value{4} * 2) + ($value{5} * 9) + ($value{6} * 8) + ($value{7} * 7) + ($value{8} * 6) + ($value{9} * 5) + ($value{10} * 4) + ($value{11} * 3) + ($value{12} * 2);
		$last = $sum2 % 11;
		$digit2 = $last < 2 ? 0 : 11 - $last;

		return ($value{12} == $digit1 && $value{13} == $digit2) ? $value : FALSE;
	}

	/**
	 * Resolve mensagem em campo de CNPJ
	 *
	 * @param unknown $message
	 * @param unknown $attribute
	 * @param unknown $rule
	 * @param unknown $parameters
	 * @return string
	 * @access public
	 * @author William Ochetski Hellas
	 */
	protected function replaceCNPJ($message, $attribute, $rule, $parameters)
	{
		if (count($parameters) > 0)
			return str_replace(':cnpj', $parameters, $message);
		else
			return $message;
	}

	/**
	 * Valida campo de telefone sem DDD
	 *
	 * @param unknown $attribute
	 * @param unknown $value
	 * @param unknown $parameters
	 * @return boolean
	 * @access public
	 * @author William Ochetski Hellas
	 */
	public function validatePhone($attribute, $value, $parameters)
	{
		// funciona com os formatos de 8 digitos:
		// 99999999
		// 9999 9999
		// 9999-9999
		// e 9 digitos:
		// 999999999
		// 99999 9999
		// 99999-9999
		return preg_match('~^(\d{4,5}[\ \.\-]?\d{4})$~', $value);
	}

	/**
	 * Resolve mensagem em campo de telefone sem DDD
	 *
	 * @param unknown $message
	 * @param unknown $attribute
	 * @param unknown $rule
	 * @param unknown $parameters
	 * @return string
	 * @access public
	 * @author William Ochetski Hellas
	 */
	protected function replacePhone($message, $attribute, $rule, $parameters)
	{
		if (count($parameters) > 0)
			return str_replace(':phone', $parameters, $message);
		else
			return $message;
	}

	/**
	 * Valida campo de telefone sem DDD
	 *
	 * @param unknown $attribute
	 * @param unknown $value
	 * @param unknown $parameters
	 * @return boolean
	 * @access public
	 * @author William Ochetski Hellas
	 */
	public function validatePhoneddd($attribute, $value, $parameters)
	{
		// funciona com os formatos de 8 digitos:
		// 9999999999
		// 999999 9999
		// 999999-9999
		// 99 99999999
		// 99 9999 9999
		// 99 9999-9999
		// (99)99999999
		// (99)9999 9999
		// (99)9999-9999
		// (99) 99999999
		// (99) 9999 9999
		// (99) 9999-9999
		// e de 9 digitos:
		// 9999999999
		// 999999 9999
		// 999999-9999
		// 99 99999999
		// 99 9999 9999
		// 99 9999-9999
		// (99)99999999
		// (99)9999 9999
		// (99)9999-9999
		// (99) 99999999
		// (99) 9999 9999
		// (99) 9999-9999
		return preg_match('~^(0?(\d{2})|\(0?(\d{2})\))[\ ]?(\d{4,5}[\ \.\-]?\d{4})$~', $value);
	}

	/**
	 * Resolve mensagem em campo de telefone sem DDD
	 *
	 * @param unknown $message
	 * @param unknown $attribute
	 * @param unknown $rule
	 * @param unknown $parameters
	 * @return string
	 * @access public
	 * @author William Ochetski Hellas
	 */
	protected function replacePhoneddd($message, $attribute, $rule, $parameters)
	{
		if (count($parameters) > 0)
			return str_replace(':phoneddd', $parameters, $message);
		else
			return $message;
	}

	/**
	 * Valida campo de CEP
	 *
	 * @param unknown $attribute
	 * @param unknown $value
	 * @param unknown $parameters
	 * @return boolean
	 * @access public
	 * @author William Ochetski Hellas
	 */
	public function validateCep($attribute, $value, $parameters)
	{
		// funciona com os formatos:
		// 99999999
		// 99.999999
		// 99999-999
		// 99.999-999
		return preg_match('~^\d{2}\.?\d{3}\-?\d{3}$~', $value);
	}

	/**
	 * Resolve mensagem em campo de CEP
	 *
	 * @param unknown $message
	 * @param unknown $attribute
	 * @param unknown $rule
	 * @param unknown $parameters
	 * @return string
	 * @access public
	 * @author William Ochetski Hellas
	 */
	protected function replaceCep($message, $attribute, $rule, $parameters)
	{
		if (count($parameters) > 0)
			return str_replace(':cep', $parameters, $message);
		else
			return $message;
	}

	/**
	 * Valida campo de data (d/m/Y)
	 *
	 * @return boolean
	 * @access public
	 * @author William Ochetski Hellas
	 */
	public function validateDatebr($attribute, $value, $parameters)
	{		
		// confere formato
		if (! preg_match('~^(?:\d{2}/){2}\d{4}$~', $value)) {
			return FALSE;
		}
		list($day, $month, $year) = explode('/', $value);
		$year = (int) $year;
		$month = (int) $month;
		$day = (int) $day;
		$date = "{$year}/{$month}/{$day}";
		// confere dia verdadeiro
		if ($date != date('Y/n/j', mktime(0, 0, 0, $month, $day, $year))) {
			return FALSE;
		}
		return TRUE;
	}

	/**
	 * Resolve mensagem em campo de data (d/m/Y)
	 *
	 * @author William Ochetski Hellas
	 */
	protected function replaceDatebr($message, $attribute, $rule, $parameters)
	{
		if (count($parameters) > 0)
			return str_replace(':datebr', $parameters, $message);
		else
			return $message;
	}
	
	/**
	 * Valida se uma data é maior que a outra 
	 *
	 * @author DTSC Engenharia de Sistemas
	 */
	public function validateDataApos($attribute, $value, $parameters)
	{
		// Recuperando valor do field passado por parametro
		$paramValue = array_get ( $this->data, $parameters[0] );
			
		// Now we do our timestamping magic!
		$d1 = implode ('', array_reverse (explode ('/', $value) ) );
		$d2 = implode ('', array_reverse (explode ('/', $paramValue) ) );
		
		if ($d1 > $d2)
		{
			return FALSE;
		}

		return TRUE;
	}
	
	/**
	 * Resolve mensagem em campo de validação de data
	 *
	 * @author DTSC ENgenharia de Sistemas
	 */
	protected function replaceDataApos($message, $attribute, $rule, $parameters)
	{
			return $message;
	}
	
	/**
	 * Valida se uma data é menor que a outra 
	 *
	 * @author DTSC Engenharia de Sistemas
	 */
	public function validateDataAnterior($attribute, $value, $parameters)
	{
		// Recuperando valor do field passado por parametro
		$paramValue = array_get ( $this->data, $parameters[0] );
			
		// Now we do our timestamping magic!
		$d1 = implode ('', array_reverse (explode ('/', $value) ) );
		$d2 = implode ('', array_reverse (explode ('/', $paramValue) ) );
		
		if ($d1 < $d2)
		{
			return FALSE;
		}

		return TRUE;
	}

	/**
	 * Valida se uma hora é maior que a outra 
	 *
	 * @author DTSC Engenharia de Sistemas
	 */
	public function validateHoraApos($attribute, $value, $parameters)
	{
		// Recuperando valor do field passado por parametro
		$paramValue = array_get ( $this->data, $parameters[0] );
			
		// Comparação
		$h1 = strtotime ($value);
		$h2 = strtotime ($paramValue);
		
		if ($h1 > $h2)
		{
			return FALSE;
		}

		return TRUE;
	}
	
	/**
	 * Resolve mensagem em campo de validação de data
	 *
	 * @author DTSC ENgenharia de Sistemas
	 */
	protected function replaceHoraApos($message, $attribute, $rule, $parameters)
	{
			return $message;
	}
	
	/**
	 * Resolve mensagem em campo de validação de data
	 *
	 * @author DTSC Engenharia de Sistemas
	 */
	protected function replaceDataAnterior($message, $attribute, $rule, $parameters)
	{
			return $message;
	}	

	/**
	 * Valida campo de hora (H:i)
	 *
	 * @param unknown $attribute
	 * @param unknown $value
	 * @param unknown $parameters
	 * @return boolean
	 * @access public
	 * @author William Ochetski Hellas
	 */
	public function validateHour($attribute, $value, $parameters)
	{
		// confere formato
		if (! preg_match('~^\d+\:[0-5]\d$~', $value)) {
			return FALSE;
		}
		return TRUE;
	}
	
	/**************************************
	 * Valida hora no formato 24 horas
	 * 
	 * @author DTSC Engenharia de Sistemas
	 */
	 public function validateHora24($attribute, $value, $parameters) {
				
		// Verifica formato
		if ( !preg_match("/(2[0-3]|[01][0-9]):([0-5][0-9])/", $value) ) {
			return FALSE;
		}
		
		return TRUE;
	 }
	 
	/**
	 * Resolve mensagem em campo de validação de data
	 *
	 * @author DTSC Engenharia de Sistemas
	 */
	protected function replaceHora24 ($message, $attribute, $rule, $parameters)
	{
			return $message;
	}	

}