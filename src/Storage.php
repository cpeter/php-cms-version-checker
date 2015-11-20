<?php

namespace Cpeter\PhpCmsVersionChecker;



class Storage {

    protected static $instance;
    protected $conn;
    
    public static function getConnection($config){
        if (self::$instance == null) {
            $db_config = new \Doctrine\DBAL\Configuration();
            $connectionParams = array(
                'url' => $config['dsn']
            );

            self::$instance = new self();
            self::$instance->conn = \Doctrine\DBAL\DriverManager::getConnection($connectionParams, $db_config);

            // Create (connect to) SQLite database in file
            // $file_db = new PDO('sqlite:../store/store.sqlite3');
            
        }

        return static::$instance;
    }

    public function getVersion($cms){
        // Fetch column as scalar value
        print_r($this->conn);
        $sth = $this->conn->query("SELECT version FROM versions WHERE name = :name");
        $sth->bindValue(":name", $cms);
        $version = $sth->fetchColumn();
        return $version;
    }

    public function putVersion($cms, $version){
        print_r($this->conn);
    }

    /**
     * Protected constructor to prevent creating a new instance of the
     * *Singleton* via the `new` operator from outside of this class.
     */
    protected  function __construct(){
    }

    /**
     * Private clone method to prevent cloning of the instance of the
     * *Singleton* instance.
     *
     * @return void
     */
    private function __clone()
    {
    }

    /**
     * Private unserialize method to prevent unserializing of the *Singleton*
     * instance.
     *
     * @return void
     */
    private function __wakeup()
    {
    }
}
