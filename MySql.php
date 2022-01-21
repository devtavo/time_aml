<?php
class MySql
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
      
        $row= mysqli_fetch_Object($result);
        
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
            //$db=$this->db;echo "".mysqli_error($this->db);
            //var_dump($result);
            //pg_close($this->db);			
            // var_dump(mysqli_error($this->db));
            
            // if ($result) {
            //     echo "".mysqli_error($db);
            // }
            mysqli_close($this->db);
            while ($item = mysqli_fetch_object($result)) {
                $rows[] = $item;
                
			}
            // while ($item = pg_fetch_object($result)) {
			// 	$rows[] = $item;
			// }
		} catch (Exception $e) {
			echo "Ocurri� un error " . $e;
		}
		return $rows;
	}
}
?>
	