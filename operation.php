<?php
	if(isset($_POST["op"]))
	{
		$op=$_POST["op"];
	}
	else
	{
		header('Location: index.php');
	}


	$servername = "localhost";
	$username = "root";
	$password = "root";
	$dbname = "try";

	try 
	{
	    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
	    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
	}
	catch(PDOException $e)
    {
    	echo "Connection failed: " . $e->getMessage();
    }

	if($op=='select')
	{
		$no=$_POST["no"];
		echo $no."<br>";
		try
		{
			$sql = "select * from xyz where No=$no";
			foreach ($conn->query($sql) as $row) 
			{
				echo "Name: " . $row["Name"]. "<br>";
			}
		} 
		catch(PDOException $e) 
		{
    		echo "No such entry";
		}
	}
	elseif ($op=='insert') 
	{
		$no=$_POST["no"];
		$name=$_POST["name"];
		echo $no."<br>";
		echo $name."<br>";
		try 
		{
			$sql = "INSERT INTO xyz VALUES ($no,'$name')";

			$conn->exec($sql); 
    		echo "Insert successfully";
		}
		catch(PDOException $e)
		{
    		echo "Error in Insert ". $e->getMessage();
		}
	}
	elseif ($op=='update') 
	{
		$no=$_POST["no"];
		$name=$_POST["name"];	
		echo $no."<br>";
		echo $name."<br>";
		try 
		{
			$sql = "UPDATE xyz SET Name='$name' WHERE No=$no";

			$conn->exec($sql); 
		    echo "Updated successfully";
		} 
		catch(PDOException $e)
		{
		    echo "Error in update";
		}
	}
	elseif ($op=='delete') 
	{
		$no=$_POST["no"];
		echo $no."<br>";
		try
		{
			$sql = "DELETE FROM xyz WHERE No='$no'";

			$conn->exec($sql);
		    echo "Deleted successfully";
		} 
		catch(PDOException $e) 
		{
		    echo "Error in delete";
		}
	}
	else
	{
		echo "No operation";
	}

	$conn=null;
?>