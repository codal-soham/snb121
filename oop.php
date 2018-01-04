<?php
	
	class DB
	{
		public function conn_open()
		{
			$servername = "localhost";
			$username = "root";
			$password = "root";
			$dbname = "try";
			
			try 
			{
		    	$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
			    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
			    echo "Connection done"."<br>";
			}
			catch(PDOException $e)
		    {
		    	echo "Connection failed: " . $e->getMessage();
		    }
		    return $conn;

		}

		public function conn_close($conn)
		{
			$conn = null;
			return $conn;
		}


		public function insert($no,$name,$conn)
		{
			echo $no."<br>";
			echo $name."<br>";
			try 
			{
				$sql = $conn->prepare("INSERT INTO xyz VALUES (:no, :name)");
		    	$sql->bindParam(':no', $new_no);
		    	$sql->bindParam(':name', $new_name);

		    	$new_no=$no;
		    	$new_name=$name;
		    	$sql->execute();

		    	echo "Insert successfully";
			}
			catch(PDOException $e)
			{
	    		echo "Error in Insert ". $e->getMessage();
			}
		}

		public function update($no,$name,$conn)
		{
			echo $no."<br>";
			echo $name."<br>";
			try 
			{
				$sql = $conn->prepare("UPDATE xyz SET Name=:name WHERE No=:no");

				$sql->bindParam(':no', $new_no);
		    	$sql->bindParam(':name', $new_name);

		    	$new_no=$no;
		    	$new_name=$name;
		    	$sql->execute(); 
			    echo "Updated successfully";
			} 
			catch(PDOException $e)
			{
			    echo "Error in update";
			}
		}

		public function select($no,$conn)
		{
			echo $no."<br>";
			try
			{
				$sql = $conn->prepare("select * from xyz where No=:no");
				$sql->bindParam(':no', $no);
		    	$sql->execute();
		    	$result = $sql->fetchAll();
		    	
				foreach ($result as $row) 
				{
					echo "Name: " . $row["Name"]. "<br>";
				}

			} 
			catch(PDOException $e) 
			{
	    		echo "No such entry";
			}
		}

		public function delete($no,$conn)
		{
			echo $no."<br>";
			try
			{
				$sql = $conn->prepare("DELETE FROM xyz WHERE No=:no");
				$sql->bindParam(':no', $new_no);

		    	$new_no=$no;
		    	$sql->execute(); 
			    echo "Deleted successfully";
			} 
			catch(PDOException $e) 
			{
			    echo "Error in delete";
			}
		}

	}



	$inst = new DB();
	$conn=$inst->conn_open();




	if(isset($_POST["op"]))
	{
		$op=$_POST["op"];
	}
	else
	{
		header('Location: index.php');
	}


	if($op=='select')
	{
		$no=$_POST["no"];
		$inst->select($no,$conn);
	}
	elseif ($op=='insert') 
	{
		$no=$_POST["no"];
		$name=$_POST["name"];
		$inst->insert($no,$name,$conn);
	}
	elseif ($op=='update') 
	{
		$no=$_POST["no"];
		$name=$_POST["name"];
		$inst->update($no,$name,$conn);
	}
	elseif ($op=='delete') 
	{
		$no=$_POST["no"];
		$inst->delete($no,$conn);
	}
	else
	{
		echo "No operation";
	}
	


	$conn=$inst->conn_close($conn);
?>