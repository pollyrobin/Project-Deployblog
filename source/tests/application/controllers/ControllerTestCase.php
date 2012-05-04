<?php

/**
 * Require dependencies for the script to run correctly
 */
require_once 'Zend/Application.php';
require_once 'Zend/Test/PHPUnit/ControllerTestCase.php';

abstract class ControllerTestCase extends Zend_Test_PHPUnit_ControllerTestCase
{
    /**
     * @var connection to the database
     */
    private $_connectionMock;

	/**
	 * @var Zend_Application
	 */
	protected $application;

    /**
     * Set up the application so it is runnable
     * 
     * @return void
     */
    public function setUp()
    {
        $this->application = new Zend_Application(
            APPLICATION_ENV,
            APPLICATION_PATH . '/configs/application.ini'
        );

        $this->bootstrap = array($this, 'appBootstrap');

        parent::setUp();
    }

    /**
     * Bootstrap the application
     *
     * @return void
     */
    public function appBootstrap()
    {
        $this->application->bootstrap();
    }

    /**
     * Sets the database connection with configuration read from application.ini
     *
     * @return 
     */
    protected function getConnection()
    {
        if ($this->_connectionMock == null) { 
            $config = $this->getConfig(); 
            $connection = Zend_Db::factory( 
                $config->resources->db->adapter, 
                array( 
                    'host' => $config->resources->db->params->host, 
                    'username' => $config->resources->db->params->username, 
                    'password' => $config->resources->db->params->password, 
                    'dbname' => $config->resources->db->params->dbname 
                ) 
            ); 
            $this->_connectionMock = new Zend_Test_PHPUnit_Db_Connection( 
                $connection, $config->resources->db->params->dbname 
            ); 
            Zend_Db_Table_Abstract::setDefaultAdapter($connection); 
        } 
        return $this->_connectionMock; 
    }    

    /**
     * Gets the application.ini and returns the testing section
     *
     * @return Zend_Config_Ini
     */
    protected function getConfig()
    {
        $applicationIni = APPLICATION_PATH .'/configs/application.ini'; 
        $config = new Zend_Config_Ini( 
            $applicationIni, 
            'testing' 
        ); 
        return $config; 
    }
}
