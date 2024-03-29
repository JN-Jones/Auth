<?php

class Smf21Test extends PHPUnit_Framework_TestCase  {
	private $hash = '$2y$13$HxdgIIWdxd6HSl8.5BCS8urINNi/HHN9sbwQ57TEJj5R0j25iK1W6';
	private $name = 'User';
	private $utf8_hash = '$2y$13$/MdC5inL/yBg3DGprSLiQuZo3PPxWy5OuKE4EH2ffMcVbu4DZnuxK';
	private $utf8_name = 'Test';
	private $password = 'thisismypassword';

	private $hasher;

	public function __construct()
	{
		require_once __DIR__.'/../vendor/illuminate/contracts/Hashing/Hasher.php';
		require_once __DIR__.'/../src/Hashing/HashSmf.php';

		$this->hasher = new \MyBB\Auth\Hashing\HashSmf();
	}


	public function testHash()
	{
		$this->assertTrue($this->hasher->check('password', $this->hash, ['name' => $this->name, 'hasher' => '2.1']));
	}

	public function testUtf8Hash()
	{
		$this->assertTrue($this->hasher->check('pässwörd', $this->utf8_hash, ['name' => $this->utf8_name, 'hasher' => '2.1']));
	}

	public function testGenerateAndValidate()
	{
		$hash = $this->hasher->make($this->password, ['name' => $this->name, 'hasher' => '2.1']);

		$this->assertTrue($this->hasher->check($this->password, $hash, ['name' => $this->name, 'hasher' => '2.1']));
	}
}