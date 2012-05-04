<?php

class IndexControllerTest extends ControllerTestCase
{
	public function testIndexAction() 
	{
		$this->disPatch('/index/');
        $this->assertResponseCode(200);
	}
}
