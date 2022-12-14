<?php
class Database
{
    protected $connect;
    protected $database;
    protected $table;
    protected $resultQuery;
    //CONTSTRUCT
    public function __construct($param)
    {
        $link = mysqli_connect($param['server'], $param['user'], $param['password']);
        if (!$link) die("<h3>Connect fail</h3>");
        $this->connect = $link;
        $this->database = $param['database'];
        $this->table = $param['table'];
        //select db
        $this->setDatabase();
    }
    //SET CONNECT
    public function setConnect($connect)
    {
        $this->connect = $connect;
    }
    //SET DATABASE
    public function setDatabase($database = null)
    {
        if ($database != null) {
            $this->database = $database;
        }
        mysqli_select_db($this->connect, $this->database);
    }
    //SET TABLE
    public function setTable($table)
    {
        $this->table = $table;
    }
    // DESTRUCT
    public function __destruct()
    {
        mysqli_close($this->connect);
    }
    //INSERT
    public function insert($data, $type = 'single')
    {
        $id = -1;
        if ($type == 'single') {
            $query = $this->createInsertQuery($data);
            $id = $this->query($query);
        } else {
            foreach ($data as $value) {
                $query = $this->createInsertQuery($value);
                $id = $this->query($query);
            }
        }
        return $id;
    }
    // CREATE INSERT QUERY
    public function createInsertQuery($data)
    {
        $attributes = [];
        $attributes['cols'] = "";
        $attributes['rows'] = "";
        foreach ($data as $key => $value) {
            $attributes['cols'] .= " ,`$key`";
            $attributes['rows'] .= " ,'$value'";
        }
        $attributes['cols'] = substr($attributes['cols'], 2);
        $attributes['rows'] = substr($attributes['rows'], 2);
        $query = "INSERT INTO `$this->table`(" . $attributes['cols'] . ") VALUES(" . $attributes['rows'] . ")";
        return $query;
    }
    // QUERY
    public function query($query)
    {
        $result = mysqli_query($this->connect, $query);
        if (!$result) echo mysqli_error($this->connect);
        return $this->resultQuery = $result;
    }
    //LAST ID
    public function lastID()
    {
        return mysqli_insert_id($this->connect);
    }
    // UPDATE
    public function update($data, $where)
    {
        $querySet = $this->createUpdateQuery($data);
        $queryWhere = $this->createWhereSQL($where);
        $query = "UPDATE `$this->table` SET $querySet WHERE $queryWhere";
        $this->query($query);
        return $this->getRecord();
    }
    // CREATE UPDATE  QUERY
    public function createUpdateQuery($data)
    {
        $attributes = "";
        foreach ($data as $key => $value) {
            $attributes .= " ,`$key`='$value'";
        }
        $attributes = substr($attributes, 2);
        return $attributes;
    }
    // CREATE WHERE
    public function createWhereSQL($data)
    {
        $whereAttr = [];
        foreach ($data as $value) {
            $whereAttr[] = "`$value[0]`= '$value[1]'";
            if (isset($value[2])) $whereAttr[] = $value[2];
        }
        return implode(' ', $whereAttr);
    }
    // GET RECORD 
    public function getRecord()
    {
        return mysqli_affected_rows($this->connect);
    }
    // DELETE
    public function delete($where)
    {
        $query = $this->createQueryDelete($where);
        $this->query($query);
        return $this->getRecord();
    }
    // CREATE QUERY DELTE
    public function createQueryDelete($data)
    {
        $strId = '';
        if (!empty($data)) {
            foreach ($data as $value) {
                $strId .= " ,'$value'";
            }
            $strId = substr($strId, 2);
        }
        return "DELETE FROM `$this->table` WHERE `id` in ($strId)";
    }
    // LIST RECORD
    public function getListRecord($resultQuery)
    {
        $resultQuery = ($resultQuery == null) ? $this->$resultQuery : $resultQuery;
        $result = [];
        if (mysqli_num_rows($resultQuery) > 0) {
            while ($row = mysqli_fetch_assoc($resultQuery)) {
                $result[] = $row;
            }
            // giai phong bo nho sau khi lay xong ket qua truy van;
            mysqli_free_result($resultQuery);
        }
        return $result;
    }
    // SINGLE RECORD
    public function getSingleRecord($resultQuery)
    {
        $resultQuery = ($resultQuery == null) ? $this->$resultQuery : $resultQuery;
        $result = [];
        if (mysqli_num_rows($resultQuery) > 0) {
            $result = mysqli_fetch_assoc($resultQuery);
            // giai phong bo nho sau khi lay xong ket qua truy van;
            mysqli_free_result($resultQuery);
        }
        return $result;
    }
}