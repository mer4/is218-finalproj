<?php

//program can be used to open every csv file and put each one into the database

ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);

class dataLoader{
	
	public function openf($file){
		$firstrow = true;
		$data;
		$fields;
		if($handle = fopen($file,"r")){
			while($row = fgetcsv($handle)){
				if($firstrow == true){
					$firstrow = false;
					$fields = $row;
				} else{
					$data[] = array_combine($fields,$row);	
				}
			}
			fclose($handle);
			return $data;
		} else{
			echo "Failed to open file " . $file;
		}
	}
	
	public function databaseWriter($records){
		$host = "localhost";
		$dbname = "college_data";
		$table = "e2011";
		$username = "root";
		$password = "password";
	
		try{
			$DBH = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
			$DBH->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
			foreach($records as $record){
				$insert = null;
				foreach($record as $key => $value){
					$insert[] = $value;
				}
				print_r($insert);
				$STH = $DBH->prepare("INSERT into $table values(?,?)");
				$STH->execute($insert);	
			}
			
			$DBH = null;
		} catch(PDOException $e){
			echo $e->getMessage();
		}
	}

}

$dfile = new dataLoader();
$data = $dfile->openf('effy2011.csv');
$dfile->databaseWriter($data);

?>
