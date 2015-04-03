<?php

class passwordGenerator
{
	// character sets
	private $cs_uc_basic      = 'ABCDEFGHJKMNPQRTUVWXYZ';
	private $cs_uc_similars   = 'ILOS';
	private $cs_lc_basic      = 'abcdefghkmnpqrtuvwxyz';
	private $cs_lc_similars   = 'ijlos';
	private $cs_num_basic     = '2346789';
	private $cs_num_similars  = '015';
	private $cs_char_basic    = '+=-_%*!';
	private $cs_char_similars = '`~:;|^.';
	private $cs_code_basic    = '&?@#<>';
	private $cs_code_similars = '$\'",(){}[]\/';
	private $cs_space         = ' ';
	
	// rules
	private $rl_length     = 30;
	private $rl_quantity   = 1;
	private $rl_duplicates = true;
	private $rl_repeat     = true;
	private $rl_similars   = true;
	private $rl_uppercase  = true;
	private $rl_lowercase  = true;
	private $rl_numeric    = true;
	private $rl_characters = true;
	private $rl_code       = true;
	private $rl_space      = false;
	
	// the rest
	private $master_string = '';
	private $password      = array();
	
	
	private function createMasterString()
	{
		if ($this->rl_uppercase)
			$this->master_string .= $this->cs_uc_basic;
			
		if ($this->rl_uppercase && $this->rl_similars)
			$this->master_string .= $this->cs_uc_similars;
		
		if ($this->rl_lowercase)
			$this->master_string .= $this->cs_lc_basic;
		
		if ($this->rl_lowercase && $this->rl_similars)
			$this->master_string .= $this->cs_lc_similars;
		
		if ($this->rl_numeric)
			$this->master_string .= $this->cs_num_basic;
		
		if ($this->rl_numeric && $this->rl_similars)
			$this->master_string .= $this->cs_num_similars;
		
		if ($this->rl_characters)
			$this->master_string .= $this->cs_char_basic;
		
		if ($this->rl_characters && $this->rl_similars)
			$this->master_string .= $this->cs_char_similars;
		
		if ($this->rl_code)
			$this->master_string .= $this->cs_code_basic;
		
		if ($this->rl_code && $this->rl_similars)
			$this->master_string .= $this->cs_code_similars;
		
		if ($this->rl_space)
			$this->master_string .= $this->cs_space;
	}
	
	
	private function isUniquePassword($stringToCheck)
	{
		if (array_search($stringToCheck,$this->password))
		{
			return false;
		}
		else
		{
			return true;
		}
	}
	
	
	private function sanityCheck()
	{
		if (strlen($this->master_string) < $this->rl_length && $this->rl_repeat == false)
			throw new Exception ('Impossible to generate password of unique characters when character list is shorter than required password length');
	}
	
	
	private function createPassword()
	{
		$string = array();
		$max = strlen($this->master_string)-1;
		
		do
		{
			$random = rand(0,$max);
			$char = $this->master_string[$random];
			if ($this->rl_repeat)
			{
				$string[] = $char;
			}
			else if (array_search($char,$string) === false)
			{
				$string[] = $char;
			}
		}
		while(count($string) < $this->rl_length);
		
		return implode('',$string);
	}
	
	
	private function createPasswordArray()
	{
		do
		{
			$password = $this->createPassword();
			
			if ($this->rl_duplicates)
			{
				$this->password[] = $password;
			}
			else if ($this->isUniquePassword($password))
			{
				$this->password[] = $password;
			}
		}
		while(count($this->password) < $this->rl_quantity);
	}
	
	
	public function generate()
	{
		$this->createMasterString();
		$this->sanityCheck();
		$this->createPasswordArray();
		
		return $this->password;
	}
	
	
	public function setLength($integer)
	{
		if (!is_int($integer) || $integer < 1 || $integer > 250)
			throw new Exception (__METHOD__.' input must be an integer between 1 and 250');
		
		$this->rl_length = $integer;
	}
	
	
	public function setQuantity($integer)
	{
		if (!is_int($integer) || $integer < 1 || $integer > 20)
			throw new Exception (__METHOD__.' input must be an integer between 1 and 250');
		
		$this->rl_quantity = $integer;
	}
	
	
	public function duplicatePasswords($bool)
	{
		if (!is_bool($bool))
			throw new Exception (__METHOD__.' input must be boolean');
		
		$this->rl_duplicates = $bool;
	}
	
	
	public function ruleRepeat($bool)
	{
		if (!is_bool($bool))
			throw new Exception (__METHOD__.' input must be boolean');
		
		$this->rl_repeat = $bool;
	}
	
	
	public function ruleSimilar($bool)
	{
		if (!is_bool($bool))
			throw new Exception (__METHOD__.' input must be boolean');
		
		$this->rl_similars = $bool;
	}
	
	
	public function ruleUppercase($bool)
	{
		if (!is_bool($bool))
			throw new Exception (__METHOD__.' input must be boolean');
		
		$this->rl_uppercase = $bool;
	}
	
	
	public function ruleLowercase($bool)
	{
		if (!is_bool($bool))
			throw new Exception (__METHOD__.' input must be boolean');
		
		$this->rl_lowercase = $bool;
	}
	
	
	public function ruleNumeric($bool)
	{
		if (!is_bool($bool))
			throw new Exception (__METHOD__.' input must be boolean');
		
		$this->rl_numeric = $bool;
	}
	
	
	public function ruleCharacters($bool)
	{
		if (!is_bool($bool))
			throw new Exception (__METHOD__.' input must be boolean');
		
		$this->rl_characters = $bool;
	}
	
	
	public function ruleCode($bool)
	{
		if (!is_bool($bool))
			throw new Exception (__METHOD__.' input must be boolean');
		
		$this->rl_code = $bool;
	}
	
	
	public function ruleSpace($bool)
	{
		if (!is_bool($bool))
			throw new Exception (__METHOD__.' input must be boolean');
		
		$this->rl_space = $bool;
	}
}
