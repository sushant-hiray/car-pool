<?php
include('functions.php');
connectdb();

if(isset($_POST['action'])){
		if($_POST['action']=='shareride') {
			$uid=getUserid();
			$from=$_POST['from'];
			$to=$_POST['to'];
			$uptime=$_POST['uptime'];
			$vehicle="car";
			$time=$_POST['time'];
			$cost=$_POST['cost'];
			$desc=$_POST['description'];
			$mode=$_POST['vehicle'];
			$number=$_POST['number'];
			if($mode=="car"){
				$vehicle="car";
			}
			else if($mode=="auto"){
				$vehicle="auto";
			}
			else if($mode=="taxi"){
				$vehicle="taxi";
			}

			mysql_query("INSERT into `offers` (`uid`,`from`,`to`,`uptime`,`people`,`price`,`vehicle`,`description`) VALUES 
				(".$uid.",'".$from."','".$to."','".$uptime."',".$number.",".$cost.",'".$vehicle."','".$desc."')") or die(mysql_error());
			header("Location: index.php?share=1");

	}
}


?>