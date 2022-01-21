<?php
class PgSql
{
    private $db;       //The db handle
    public  $num_rows; //Number of rows
    public  $last_id;  //Last insert id
    public  $aff_rows; //Affected rows
    public function __construct()
    {
        require 'config.php';
        $this->db = mysqli_connect($host,$user,$passwd,$dbname);
        if (!$this->db) exit();
        
    }
	
	public function getRow($sql)
    {
        //$result = pg_query($this->db, $sql);
        $result=mysqli_query($this->db,$sql);
        //$row = pg_fetch_object($result);
        $row= mysqli_fetch_object($result);
            //if (pg_last_error()) exit(pg_last_error());
        if(mysqli_errno($this->db)) exit(mysqli_errno($this->db));
        
        return $row;
    }
	
	public function getRows($sql)
    {
		$rows = array();
		
		try {
            //$result = pg_query($this->db, $sql);
            $result = mysqli_query($this->db,$sql);
			//pg_close($this->db);			
            mysqli_close($this->db);
            while ($item = mysqli_fetch_object($result)) {
				$rows[] = $item;
			}
            // while ($item = pg_fetch_object($result)) {
			// 	$rows[] = $item;
			// }
		} catch (Exception $e) {
			echo "Ocurri� un eror " . $e;
		}
		return $rows;
	}
}
?>
	