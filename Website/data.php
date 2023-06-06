 <?php
$database = "irrigation";
$conn =  new mysqli("localhost:3306","root","",$database);
if(!$conn)
{

  die("Connection Error" .$conn->connect_error);
}

$temp = $_POST['temp'];
$humid = $_POST['humid'];
$moist = $_POST['moist'];
$manual_stat = $_POST['manual'];
$pump_stat = $_POST['pump_stat'];

$sql = "INSERT INTO data (temp, humid, moist, manual_switch_stat, pump_stat) VALUES ('$temp','$humid' ,'$moist','$manual_stat' ,'$pump_stat')";
if ($conn->query($sql) === TRUE) {
   echo "data Saved Successfully";
} else {
    echo "Error:" . $sql . "<br>" . $conn->error;
}
$conn->close();
?>
