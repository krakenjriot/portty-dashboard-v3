<?php
	//header("Content-Type: application/text; charset=UTF-8");
	//include ("../session.php");
	include ("../dbconnect.php");
	include ("../functions.php");
	$pins = "";
	$pinx = "";
    $file = "../exe/conf/all.output";
	
	//reset
	file_put_contents($file, "");
	
	$sql1 = "SELECT * FROM tbl_boards ORDER BY board_name ASC";
    $result1 = mysqli_query($conn, $sql1);
	
    if (mysqli_num_rows($result1) > 0)
    {					
        // output data of each row
        while ($row1 = mysqli_fetch_assoc($result1))
        {    
			$board_name = $row1['board_name'];
			///////////////////////////////////////////////////////
			$sql2 = "SELECT * FROM tbl_pins WHERE board_name = '$board_name' ORDER BY pin_num ASC";
			$result2 = mysqli_query($conn, $sql2);
			
			//reset the pins for next board
			$pins = "";

			if (mysqli_num_rows($result2) > 0)
			{
				// output data of each row
				while ($row2 = mysqli_fetch_assoc($result2))
				{			
					$pins .= $row2['active'];
				}		
								
			}
			//echo $pins. "</br>";	
			
			///////////////////////////////////////////////////////			
			
			
			//file_put_contents($file, PHP_EOL . $payload, FILE_APPEND);	
			$pinx .= "'$board_name':,'$pins'</br>";
        }
		
		
			
			//echo $board_name. "</br>";			
			//echo $pinx; //. "</br>";
            

    }
	
	echo $pinx;	



/*
[
    {"name": "John Doe", "occupation": "gardener", "country": "USA"},
    {"name": "Richard Roe", "occupation": "driver", "country": "UK"},
    {"name": "Sibel Schumacher", "occupation": "architect", "country": "Germany"},
    {"name": "Manuella Navarro", "occupation": "teacher", "country": "Spain"},
    {"name": "Thomas Dawn", "occupation": "teacher", "country": "New Zealand"},
    {"name": "Morris Holmes", "occupation": "programmer", "country": "Ireland"}
]
*/
	//$str = file_get_contents("../exe/conf/all.output");
	
	//echo "<pre>".$str."</pre>";
	



?>