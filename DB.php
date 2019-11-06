<?php
class DB {

    // Property untuk koneksi ke database mysql
    private $_host      = '127.0.0.1';
    private $_dbname    = 'ilkoom';
    private $_username  = 'root';
    private $_password  = '';

    // Property internal dari class DB
    private static $_instance = null;
    private $_pdo;  // menampung object PDO
    private $_columnName = "*";
    private $_orderBy    = "";
    private $_count      = 0;

    // Constructor untuk pembuatan PDO Object
    public function __construct()
    {
        try {
            $this->_pdo = new PDO('mysql:host='.$this->_host.';dbname='.$this->_dbname, $this->_username, $this->_password);
            $this->_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Koneksi / Query bermasalah: ".$e->getMessage(). " (".$e->getCode().")");
        }
    }
        
    // Singleton pattern for making class DB
    public static function getInstance()
    {
        if (!isset(self::$_instance)) {
            self::$_instance = new DB();
        }
        return self::$_instance;
    }

      // basic method to run prepared statement query
    public function runQuery($query, $bindValue = []) 
    {
        try {
            $stmt = $this->_pdo->prepare($query);
            $stmt->execute($bindValue);
        } catch (PDOException $e) {
            die("Koneksi / Query bermasalah: ".$e->getMessage(). " (".$e->getCode().")");
        }
        return $stmt;
    }

    // This method is used to show the result from select query as Object
    public function getQuery($query, $bindValue = [])
    {
        return $this->runQuery($query, $bindValue)->fetchAll(PDO::FETCH_OBJ);
    }

    // Main method to get the data of table
    public function get($tableName, $condition = "", $bindValue = [])
    {
    $query = "SELECT {$this->_columnName} FROM {$tableName} {$condition} {$this->_orderBy}";
        $this->_columnName  = "*";
        $this->_orderBy     = "";
        return $this->getQuery($query, $bindValue);
    }

    // Select Method to filter db column 
    public function select($columnName)
    {
        $this->_columnName = $columnName;
        return $this;
    }

    // ORDER BY method
    public function orderBy($columnName, $sortType = 'ASC')
    {
        $this->_orderBy = "Order By {$columnName} {$sortType}";
        return $this;
    }

    // getWhere Method
    public function getWhere($tableName, $condition)
    {
        $queryCondition = "WHERE {$condition[0]} {$condition[1]} ?";
        return $this->get($tableName, $queryCondition, [$condition[2]]);
    }

    // getWhereOnce Method
    public function getWhereOnce($tableName, $condition)
    {
        $result = $this->getWhere($tableName, $condition);
        if (!empty($result)) {
            return $result[0];
        } else {
            return false;
        }
    }

    // getLike Method
    public function getLike($tableName, $columnLike, $search)
    {
        $queryLike = "WHERE {$columnLike} LIKE ?";
        return $this->get($tableName, $queryLike, [$search]);
    }

    // Check method
    public function check($tableName, $columnName, $dataValues)
    {
    $query = "SELECT {$columnName} FROM {$tableName} WHERE {$columnName} = ?";
    return $this->runQuery($query,[$dataValues])->rowCount();
    }

    // INSERT Method
    public function insert($tableName, $data)
    {
        $dataKeys     = array_keys($data);
        $dataValues   = array_values($data);
        $placeholder  = '('. str_repeat('?,', count($data) -1 ) . '?)';

        $query        = "INSERT INTO {$tableName} (". implode(',' , $dataKeys) . ") VALUES {$placeholder}";
        $this->_count = $this->runQuery($query, $dataValues)->rowCount();
        return true;
    }

    public function count()
    {
        return $this->_count;
    }

    // Update Method
    public function update($tableName, $data, $condition)
    {
        $query = "UPDATE {$tableName} SET ";
        foreach ($data as $key => $value) {
            $query .= "$key = ?, ";
        }
        $query  = substr($query,0,-2);
        $query .= " WHERE {$condition[0]} {$condition[1]} ?";
        
        $dataValues = array_values($data);
        array_push($dataValues, $condition[2]);
        
        $this->_count = $this->runQuery($query, $dataValues)->rowCount();
        return true;
    }

    // This method is used to delete data
    public function delete($tableName, $condition)
    {
    $query = "DELETE FROM {$tableName} WHERE {$condition[0]} {$condition[1]} ?";
    $this->_count = $this->runQuery($query, [$condition[2]])->rowCount();
    return true;
    }
    
}