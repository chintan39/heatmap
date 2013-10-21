<?php

class SQL {
    protected $_dbHandle;
    protected $_result;

    /** Connects to database **/

    function connect($address, $account, $pwd, $name) {
        $this->_dbHandle = @mysql_connect($address, $account, $pwd);
        if ($this->_dbHandle != 0) {
            if (mysql_select_db($name, $this->_dbHandle)) {
                return 1;
            }
            else {
                return 0;
            }
        }
        else {
            return 0;
        }
    }
    /** Disconnects from database **/

    function disconnect() {
        if (@mysql_close($this->_dbHandle) != 0) {
            return 1;
        }  else {
            return 0;
        }
    }


    /** Custom SQL Query **/

	function query($query, $singleResult = 0) 
        {
            $this->_result = mysql_query($query, $this->_dbHandle);
            if (!$this->_result) 
            {
                echo 'Could not run query: ' . mysql_error();
                echo "<br/>";
                echo $query;
                exit();
            }
            if (preg_match("/select/i",$query)) 
            {
                $result = array();
                $table = array();
                $field = array();
                $tempResults = array();
                $numOfFields = mysql_num_fields($this->_result);
                for ($i = 0; $i < $numOfFields; ++$i) 
                {
                    array_push($table,mysql_field_table($this->_result, $i));
                    array_push($field,mysql_field_name($this->_result, $i));
                }
                while ($row = mysql_fetch_row($this->_result)) 
                {
                    for ($i = 0; $i < $numOfFields; ++$i) 
                    {
                        $table[$i] = trim(ucfirst($table[$i]), "s");
                        $tempResults[$field[$i]] = $row[$i];
                    }
                    if ($singleResult == 1) 
                    {
                        mysql_free_result($this->_result);
                        return $tempResults;
                    }
                    array_push($result, $tempResults);
                }
                mysql_free_result($this->_result);        
                return($result);
            }
            if (preg_match("/insert/i",$query)) 
            {
                    return mysql_insert_id();
            }
            if (preg_match("/update/i",$query)) 
            {
                    return mysql_affected_rows();
            }
            
	}


    /** Free resources allocated by a query **/

    function freeResult() {
        mysql_free_result($this->_result);
    }

    /** Get error string **/

    function getError() {
        return mysql_error($this->_dbHandle);
    }
}