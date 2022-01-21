<?php

$connect = new PDO("mysql:host=localhost;dbname=testing", "root", "");

$query = "SELECT * FROM timeline ORDER BY id ASC";
$statement = $connect->prepare($query);
$statement->execute();
$result = $statement->fetchAll();

?>

<html>  
    <head>  
        <title>How to Create Dynamic Timeline in PHP</title>
        <script src="js/jquery.js"></script>
        <script src="js/timeline.min.js"></script>
		<link rel="stylesheet" href="css/bootstrap.min.css" />
        <link rel="stylesheet" href="css/timeline.min.css" />
		
    </head>  
    <body>  
        <div class="container">
			<br />
			<h3 align="center"><a href="">How to Create Dynamic Timeline in PHP</a></a></h3><br />
			<div class="panel panel-default">
				<div class="panel-heading">
                    <h3 class="panel-title">Our Journey</h3>
                </div>
                <div class="panel-body">
                	<div class="timeline">
                        <div class="timeline__wrap">
                            <div class="timeline__items">
                            <?php
                            foreach($result as $row)
                            {
                            ?>
                            	<div class="timeline__item">
                                    <div class="timeline__content">
                                    	<h2><?php echo $row["year"]; ?></h2>
                                    	<p><?php echo $row["comment"]; ?></p>
                                    </div>
                                </div>
                            <?php
                            }
                            ?>
                            </div>
                        </div>
                    </div>
                </div>
			</div>
		</div>
    </body>  
</html>

<script>
$(document).ready(function(){
    jQuery('.timeline').timeline();
});
</script>