<?php
class SqlSrv
{
    private $db;
	
    public function __construct()
    {
        require 'config_sqlsrv.php';
        $this->db = sqlsrv_connect($serverName, $connectionInfo);
        if (!$this->db) exit();
    }
	
	public function getRow($sql)
    {
        $result = sqlsrv_query($this->db, $sql);
        $row    = sqlsrv_fetch_object($result);
        if (sqlsrv_errors()) exit(sqlsrv_errors());
        return $row;
    }
	
	public function getRows($sql)
    {
		$rows = array();
		
		try {
			$result = sqlsrv_query($this->db, $sql);			
			while ($item = sqlsrv_fetch_object($result)) {
				$rows[] = $item;
			}
			sqlsrv_close($this->db);	
		} catch (Exception $e) {
			echo "Ocurrió un eror " . $e;
		}
		return $rows;
	}
}
?>
	