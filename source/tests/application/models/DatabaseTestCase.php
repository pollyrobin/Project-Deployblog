<?php
require_once 'Zend/Test/PHPUnit/DatabaseTestCase.php';

abstract class DatabaseTestCase extends Zend_Test_PHPUnit_DatabaseTestCase
{
    /**
     * @var connection to the database
     */
    private $_connectionMock;

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
            $this->_connectionMock = $this->createZendDbConnection( 
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
