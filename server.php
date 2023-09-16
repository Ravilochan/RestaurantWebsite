<?php
session_start();
$username=$_SESSION['username'];
$conn=mysqli_connect("localhost","root","","chef");

$des=mysqli_query($conn,"SELECT `designation` FROM `users` WHERE username='$username'");
$data= mysqli_fetch_array($des);
$designation=$data['designation'];


$totalbill=$_POST['total'];
$customer_money=$_POST['money'];
$retrun_money=$_POST['return_money'];
$timing=date("d-m-Y h:i:sa");
echo "$timing";



$particulars =" Dosa : ".$_POST['quantity1']."  Idli : ".$_POST['quantity2']."  Bajji : ".$_POST['quantity3']."  Wada : ".$_POST['quantity4']."  Puri : ".$_POST['quantity5'] ;
echo "$particulars";



$query = "INSERT INTO bill( username, timing , designation, particulars , totalbill ,customer_money , return_money ) 
VALUES('$username','$timing', '$designation', '$particulars','$totalbill','$customer_money','$retrun_money')";

if(mysqli_query($conn,$query))
{
echo "entered database";
}
else{
    echo "Not entered database";
}

header("location:bill.html");
?>