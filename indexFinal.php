<?php

//ini_set('display_errors', 'On');
//error_reporting(E_ALL | E_STRICT);

$project = new indexFinal();

class indexFinal{
	
	function __construct(){
		$page = 'home';
		$arg = NULL;
		if(isset($_REQUEST['page'])){
			$page = $_REQUEST['page'];
		}
		if(isset($_REQUEST['arg'])){
			$arg = $_REQUEST['arg'];
		}
		$page = new $page($arg);
	}
	
}
	
abstract class page{
	
	public $content;
	
	function __construct($arg = NULL){
		if($_SERVER['REQUEST_METHOD'] == 'GET'){
			$this->get();
		} else{
			$this->post();
		}
	}
	
	function get(){
	}
	
	function post(){
	}
	
	function __destruct(){
		echo $this->content;
	}
		
}
	
class home extends page{
	
	function get(){
		$this->content = '<h3>Final Project</h3><br>
		<a href = "?page=Ques1"> Colleges with the highest enrollments in 2011 : </a><br>
		<a href = "?page=Ques2"> Colleges with the largest amount of total liabilities in 2011 : </a><br>
		<a href = "?page=Ques3"> Colleges with the largest amount of net assets in 2011 : </a><br>
		<a href = "?page=Ques4"> Colleges with the largest amount of net assets per student in 2011 : </a><br>
		<a href = "?page=Ques5"> Colleges with the largest percentage increase in enrollment between 2011 and 2010 : </a><br>';
	}
	
}

class Ques1 extends page{
	
	function get(){
		$host = "localhost";
		$dbname = "college_data";
		$username = "root";
		$password = 'password';
		try{
			$DBH = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
			$DBH->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
			$STH = $DBH->query("SELECT college.Name, Enroll2011 FROM e2011 INNER JOIN college ON e2011.UNITID = college.UID ORDER BY e2011.Enroll2011 DESC");
		
			$this->content .= "<h3>Highest Enrollment in 2011</h3><br>";
			$this->content .= "<table border = 1>";
			$this->content .= "<tr>
				<th>College Name</th>
				<th>Enrollment</th>
				</tr>";
		
			while($lines = $STH->fetch()){
				$this->content .= "<tr>";
				$this->content .= "<td>" . $lines['Name'] . "</td>";
				$this->content .= "<td>" . $lines['Enroll2011'] . "</td>";
				$this->content .= "</tr>";
			}
		
			$this->content .= "</table>";
			$DBH = null;
		} catch(PDOException $e){
			echo $e->getMessage();
		}
		
	}
}

class Ques2 extends page{
}

class Ques3 extends page{
}

class Ques4 extends page{
}

class Ques5 extends page{
}

?>
