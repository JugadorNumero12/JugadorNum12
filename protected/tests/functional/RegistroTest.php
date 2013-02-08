<?php

class RegistroTest extends WebTestCase
{
	public function testIndex()
	{
		//Página a testear
		$this->open('registro');
		//Comprobamos existencia del siguiente texto
		$this->assertTextPresent('REGISTRAR');
	}
}
