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

			$query="SELECT id from offers WHERE `uid`=".$uid." AND `from`='".$from."' AND `to`='".$to."' AND `uptime`='".$uptime."' AND `people`=".$number." AND `price`=".$cost." AND `vehicle`='".$vehicle."' AND `description`='".$desc."'";
			$result=mysql_query($query) or die(mysql_error());
			$ans=mysql_fetch_array($result);
			$cid=$ans['id'];
			mysql_query("INSERT INTO route (`cid`,`place`,`serialno`) VALUES(".$cid.",'".$from."',1)") or die("pehla".mysql_error());
			$num=$_POST['totalRequests'];
			for($i=1;$i<=$num;$i++){
				$id="dynamic".(string)$i;
				$data=$_POST[$id];
				$j=$i+1;
				mysql_query("INSERT INTO route (`cid`,`place`,`serialno`) VALUES(".$cid.",'".$data."',".$j.")") or die("bichka".mysql_error());
			}
			$j=$i+1;
			mysql_query("INSERT INTO route (`cid`,`place`,`serialno`) VALUES(".$cid.",'".$to."',".$j.")") or die("aakhri".mysql_error());


			header("Location: index.php?share=1");

	}
}


?>