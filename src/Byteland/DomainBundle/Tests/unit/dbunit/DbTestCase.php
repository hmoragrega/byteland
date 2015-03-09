<?php

namespace Byteland\DomainBundle\Tests\unit\dbunit;

use PDO;
use PHPUnit_Extensions_Database_TestCase;

/**
 * Class for testing the DB
 *
 * @package Byteland\DomainBundle\Tests\unit\dbunit
 */
class DbTestCase extends PHPUnit_Extensions_Database_TestCase
{
    /**
     * @var PDO Unique connection for tests queries
     */
    private static $pdo = null;

    private $conn = null;

    /**
     * Doctrine entity manager
     *
     * @var \Doctrine\ORM\EntityManager
     */
    protected static $entityManager;

    public function __construct($name = null, array $data = array(), $dataName = '')
    {
        if (null === self::$entityManager) {
            $kernel = new \AppKernel('dev', false);
            $kernel->boot();

            $container = $kernel->getContainer();
            self::$entityManager = $container->get('doctrine')->getManager();
        }

        parent::__construct($name, $data, $dataName);
    }

    final public function getConnection()
    {
        if ($this->conn === null) {
            if (self::$pdo == null) {
                self::$pdo = new PDO( $GLOBALS['DB_DSN'], $GLOBALS['DB_USER'], $GLOBALS['DB_PASSWD'] );
            }
            $this->conn = $this->createDefaultDBConnection(self::$pdo, $GLOBALS['DB_DBNAME']);
        }

        return $this->conn;
    }

    public function getDataSet()
    {
        return $this->createMySQLXMLDataSet(dirname(__FILE__).'/../../../Resources/datasets/byteland.xml');
    }

    public function getSetUpOperation()
    {
        return new \PHPUnit_Extensions_Database_Operation_Composite(array(
            new TruncateOperation(true),
            \PHPUnit_Extensions_Database_Operation_Factory::INSERT()
        ));
    }
}