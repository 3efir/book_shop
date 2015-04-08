<?php
class DataBase
{
    private static $instance = null;
    protected $dbh;
    protected $sql;
    private function __construct()
    {
        $this->sql = '';
        try
        {
            $this->dbh = new PDO("mysql:host=".HOST.";dbname=".BD,USER,PASSWORD);
        }
        catch (Exception $e)
        {
            echo $e->getMessage();
        }
    }
    static public function getInstance()
    {
        if (is_null(self::$instance))
        {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function INSERT($table)
    {
        $this->sql = '';
        if ($table !== '')
        {
            $this->sql = 'INSERT INTO '.$table;
            return $this;
        }
        else
        {
            throw new Exception ("enter table name");
        }
    }
    public function keys($keys)
    {
        if($keys !== '')
        {
            $this->sql .= "($keys)";
            return $this;
        }
        else
        {
            throw new Exception ('enter field name');
        }
    }
    public function values($values)
    {
        if ($values !== '')
        {
            $this->sql .= "VALUES ($values)";
            return $this;
        }
        else
        {
            throw new Exception ("enter value for insert");
        }
    }
    public function SELECT($fields)
    {
        $this->sql = '';
        if($fields !== '' && $fields !== '*')
        {
            $this->sql .= 'SELECT '.$fields;
            return $this;
        }
        else
        {
            throw new Exception ("no fields for select");
        }
    }
    public function from($table)
    {
        if ($table !== '')
        {
            $this->sql .= 'FROM '.$table;
            return $this;
        }
        else
        {
            throw new Exception ("enter table name");
        }
    }
    public function where($where)
    {
        if($where !== '')
        {
            $this->sql .= " WHERE $where";
            return $this;
        }
        else
        {
            throw new Exception ("no value for operator where");
        }
    }
	public function whereAnd($and)
	{
		if($and !== '')
        {
            $this->sql .= " AND $and";
            return $this;
        }
        else
        {
            throw new Exception ("no value for operator where and");
        }
	}
    public function limit($lim)
    {
        if($lim !== '' && is_int($lim))
        {
            $this->sql .= 'LIMIT '.$limit;
            return $this;
        }
        else
        {
            throw new Exception ("not corect value for operator limit");
        }
    }
    public function UPDATE($table)
    {
        $this->sql = '';
        $this->sql .= 'UPDATE '.$table;
        return $this;
    }
    public function SET($field)
    {
        $this->sql .= ' SET '.$field.' = ? ';
        return $this;
    }
    public function DELETE($fields)
    {
        $this->sql = '';
        $this->sql .= 'DELETE '.$fields;
        return $this;
    }
    public function insertUpdate($arr)
    {
        if($this->sql !== '')
        {
            $sth = $this->dbh->prepare($this->sql);
            if($arr !== '')
            {
                if ($sth->execute($arr))
                {
                    return true;
                }
                else
                {
                    throw new Exception ('This values isset in DB');
                }
            }
            else
            {
                throw new Exception ("No values for insert/update");
            }
        }
        else
        {
            throw new Exception ("not corect sql for insert/update");
        }
    }
    public function selected()
    {
        if($this->sql !== '')
        {
            $sth = $this->dbh->prepare($this->sql);
            $sth -> execute();
            $sth->setFetchMode(PDO::FETCH_ASSOC);
            $res = array();
            $row = $sth->fetchAll();
            return $row;
        }
        else
        {
            throw new Exception ("failed");
        }
    }
    function deleted()
    {
        $save = $this->dbh->quote($this->sql);
        if($this->dbh->exec($save))
        {
            $this->sql = '';
            return true;
        }
        else
        {
            throw new Exception ("some wrong with delete");
        }
    }
	public function inner($tb)
	{
		if(trim($tb) !== '')
		{
			$this -> sql .= 'INNER JOIN '.$tb;
			return $this;
		}
		else
		{
			throw new Exception ("not correct input for inner join");
		}
	}
	public function on($fields)
	{
		if(trim($fields) !== '')
		{
			$this -> sql .= 'ON '.$fields;
			return $this;
		}
		else
		{
			throw new Exception ("not correct input for ON");
		}
	}
	public function GROUP($fields)
	{
		$this -> sql .= " GROUP BY ".$fields;
		return $this;
	}
	public function left($tb)
	{
		if(trim($tb) !== '')
		{
			$this -> sql .= 'LEFT JOIN '.$tb;
			return $this;
		}
		else
		{
			throw new Exception ("not correct input for inner join");
		}
	}

}
?>