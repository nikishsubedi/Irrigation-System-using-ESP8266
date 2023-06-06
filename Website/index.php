<?php 
	$database = "irrigation";
   $conn =  new mysqli("localhost:3306","root","",$database);
if(!$conn)
{

  die("Connection Error" .$conn->connect_error);
}
?>


<?php $ip ="192.168.0.41";
$pump_stat= "OFF";
$manual_switch_stat= "OFF";

$res=mysqli_query($conn,"select * from data ORDER BY ID DESC LIMIT 1");
while($row=mysqli_fetch_array($res))
{
$manual_switch_stat=$row["manual_switch_stat"];
$pump_stat=$row["pump_stat"];
}
?>



<!DOCTYPE html><html>
<head><meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Smart Irrigation System </title>
  <meta charset="utf-8">
  <meta http-equiv="refresh" content="10">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.3/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
	  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
 <link rel="shortcut icon" href="https://lh6.googleusercontent.com/4zdsKO4PuiyWHJegRCNEZTMBXa7ufvTdr8Lai_nmT8NuTimIlFgNstT6iW1E4__zsig=w2400" >
<style>html { font-family: Helvetica; display: inline-block; margin: 0px auto; text-align: center;}
.buttonRed { background-color: #ff0000; border: none; color: white; padding: 16px 40px; border-radius: 10%;
text-decoration: none; font-size: 30px; margin: 2px; cursor: pointer;}");
.buttonGreen { background-color: #00ff00; border: none; color: white; padding: 16px 40px; border-radius: 10%;
text-decoration: none; font-size: 30px; margin: 2px; cursor: pointer;}");
.buttonYellow { background-color: #feeb36; border: none; color: white; padding: 16px 40px; border-radius: 10%;
text-decoration: none; font-size: 30px; margin: 2px; cursor: pointer;}");
.buttonOff { background-color: #77878A; border: none; color: white; padding: 16px 40px; border-radius: 10%;
text-decoration: none; font-size: 30px; margin: 2px; cursor: pointer;
}
 .datetime{
          font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
          font-weight: bold;
          width: 440px;
        }
        .date{
          font-size: 20px;
          font-weight: 600;
          text-align: center;
        }
        .time{
          font-size: 30px;
          display: flex;
          justify-content: center;
          align-items: center;
        }
        .time span:not(:last-child){
          position: relative;
          margin: 0 4px;
          font-weight: 600;
          text-align: center;
          letter-spacing: 3px;
        }
	.time span:last-child{
	  background: black;
	  font-size: 14px;
	  font-weight: 600;
	  color: white;
	  text-transform: uppercase;
	  margin-top: 10px;
	  padding: 0 5px;
	  border-radius: 3px ;
	}
			
footer {
  position: fixed;
  left: 0;
  bottom: 0;
  width: 100%;
  background-color: red;
  color: white;
  text-align: center;
}

body {
    background-color: #eee
}

.card {
    border: none;
    border-radius: 10px
}

.c-details span {
    font-weight: 300;
    font-size: 13px
}

.icon {
    width: 50px;
    height: 50px;
    background-color: #eee;
    border-radius: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 39px
}

.badge span {
    background-color: #fffbec;
    width: 60px;
    height: 25px;
    padding-bottom: 3px;
    border-radius: 5px;
    display: flex;
    color: #fed85d;
    justify-content: center;
    align-items: center
}

.progress {
    height: 10px;
    border-radius: 10px
}

.progress div {
    background-color: red
}

.text1 {
    font-size: 14px;
    font-weight: 600
}

.text2 {
    color: #a5aec0
}

.content {
  margin: auto;
}

        .separator{
          border-right: 6px solid #99B8A4;
          display: block;
          height: 250px;
          position: relative;
          top: 0px;
        }
		
		
.btn_led1 {
  padding: 10px;
  font-size: 20px;
  color: white;
  background-color:#00e64d;
  border-radius: 5px;
  text-align: center;

}


.btn_led2 {
  padding: 10px;
  font-size: 20px;
  color: white;
  background-color:#00e64d;
  border-radius: 5px;
  text-align: center;
}
 


</style></head>

<body onload="initClock()" class="light-theme">

<nav class="navbar navbar-light" style="background-color: #99B8A4;">
  <a class="navbar-brand" href="#">
    <img src="https://lh6.googleusercontent.com/M2AztF_fRjUpnDeB0_KUFgx1ee-vxW97mkALaeshsrzA5FayYTvE_S6KxNAWWmCl6Cg=w2400" width="35" height="35" class="d-inline-block align-top" alt="">
    IOT based Smart Irrigation System
  </a>
        <div class="datetime">
        <div class="date">
          <span id="dayname">Day</span>,
          <span id="month">Month</span>
          <span id="daynum">00</span>,
          <span id="year">Year</span>
        </div>
        <div class="time">
          <span id="hour">00</span>:
          <span id="minutes">00</span>:
          <span id="seconds">00</span>
          <span id="period">AM</span>
        </div>
      </div>
</nav>
</br></br></br>
<div class="content">
<h2 style="color:white; font-size:40px; background-color:green; text-align: center;">Data Monitoring </h2> 
<div class="container mt-5 mb-3">
    <div class="row">
        <div class="col-md-3">
            <div class="card p-3 mb-2">
                <div class="d-flex justify-content-between">
                    <div class="d-flex flex-row align-items-center">
                        <div class="icon">     <img src="https://lh3.googleusercontent.com/Q5Fttky_DYo114ZGRig7TFlmorXoOB5VNO1GxCPidjtJBwr3v1DEpPDEQ4IoJ2e68Lw=w2400" width="30" height="30"alt=""> </div>
                        <div class="ms-2 c-details">
                            <h4 class="mb-0"><b>Temperature (&#176C)</b></h4>
                        </div>
                    </div>
                </div>
                <div class="mt-5">
                    <h3 class="heading">         <?php
            $res=mysqli_query($conn,"select * from data ORDER BY ID DESC LIMIT 1");
			while($row=mysqli_fetch_array($res))
	         {echo $row["temp"]; }
	     ?>&#176C</h3>
                    <div class="mt-5">
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" style="width: <?php
            $res=mysqli_query($conn,"select * from data ORDER BY ID DESC LIMIT 1");
			while($row=mysqli_fetch_array($res))
	         {echo $row["temp"]; }
	     ?>%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <div class="mt-3"> <span class="text2">Surrounding Temperature</span></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-3 mb-2">
                <div class="d-flex justify-content-between">
                    <div class="d-flex flex-row align-items-center">
                 <div class="icon">     <img src="https://lh6.googleusercontent.com/VY-a3Ua9N2qDokAa98yw1YPVsPIWJRZXcnxqPLB3aYw9fAIlTTi2hDhXHEFwXFd7p8U=w2400" width="30" height="30"alt=""> </div>
                        <div class="ms-2 c-details">
                            <h4 class="mb-0"><b>Humidity</b></h4>
                        </div>
                    </div>
                </div>
                <div class="mt-5">
                    <h3 class="heading">         <?php
            $res=mysqli_query($conn,"select * from data ORDER BY ID DESC LIMIT 1");
			while($row=mysqli_fetch_array($res))
	         {echo $row["humid"]; }
	     ?>%</h3>
                    <div class="mt-5">
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" style="width:   <?php
            $res=mysqli_query($conn,"select * from data ORDER BY ID DESC LIMIT 1");
			while($row=mysqli_fetch_array($res))
	         {echo $row["humid"]; }
	     ?>%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                                   <div class="mt-3"> <span class="text2">Surrounding Humidity</span></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-3 mb-2">
                <div class="d-flex justify-content-between">
                    <div class="d-flex flex-row align-items-center">
                 <div class="icon">     <img src="https://lh5.googleusercontent.com/JpZ5rlMJaO-4nm61mdwQMWbLkAQ_XjAvruv_gBbuZ6ntfhgBLxh6pSGQZQfAL0MSqP0=w2400" width="30" height="30"alt=""> </div>
                        <div class="ms-2 c-details">
                            <h4 class="mb-0"><b>Soil Moisture </b></h4>
                        </div>
                    </div>
                </div>
                <div class="mt-5">
                    <h3 class="heading">         <?php
            $res=mysqli_query($conn,"select * from data ORDER BY ID DESC LIMIT 1");
			while($row=mysqli_fetch_array($res))
	         {echo $row["moist"]; }
	     ?>%</h3>
                    <div class="mt-5">
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" style="width: <?php
            $res=mysqli_query($conn,"select * from data ORDER BY ID DESC LIMIT 1");
			while($row=mysqli_fetch_array($res))
	         {echo $row["moist"]; }
	     ?>%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                             <div class="mt-3"> <span class="text2">Moisture Level of Soil</span></div>
                    </div>
                </div>
            </div>
        </div>
		
		
		        <div class="col-md-3">
            <div class="card p-3 mb-2">
                <div class="d-flex justify-content-between">
                    <div class="d-flex flex-row align-items-center">
                 <div class="icon">     <img src="https://lh3.googleusercontent.com/drive-viewer/AAOQEOT9yJ7ftWijEuvUL-bSuiRn0Ftt9pkXX1rkZFUK1C7iSO6Bo_GGpMi6_x0ZtU47SRUcqDpK9lKPhtzwMWLBPqJeefEAMQ=s2560" width="30" height="30"alt=""> </div>
                        <div class="ms-2 c-details">
                            <h4 class="mb-0"><b>Pump Status</b></h4>
                        </div>
                    </div>
                </div>
                <div class="mt-5">
                    <h3 class="heading">         <?php
            $res=mysqli_query($conn,"select * from data ORDER BY ID DESC LIMIT 1");
			while($row=mysqli_fetch_array($res))
	         {echo $row["pump_stat"]; }
	     ?></h3>
                    <div class="mt-5">
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                             <div class="mt-3"> <span class="text2">Check if Motor is ON or OFF</span></div>
                    </div>
                </div>
            </div>
        </div>
		
    </div>
</div>


<div class="text-center">
<h2 style="color:white; font-size:35px; text-align: center; width:40%; background-color:green">Control Switches</h2>
</div>

<div class="container">
  <div class="row">
    <div class="col-sm">
	
<div style="margin-left :50px;">
<h3>MANUAL MODE<h3>  
<input type="button" NAME="butname" class="btn_led1" value="<?php if($manual_switch_stat==="OFF"){echo "Turn ON";} else {echo "Turn OFF";}?>"/>
<br></br>
<?php if($manual_switch_stat==="ON")
{
	echo "<h3>PUMP SWITCH</h3>";
	if($pump_stat==="OFF")
	{
 echo "<input type=\"button\" NAME=\"butname2\" class=\"btn_led2\" value=\"Turn ON\"/>";
	 
	}
	else{
		 echo "<input type=\"button\" NAME=\"butname2\" class=\"btn_led2\" value=\"Turn OFF\"/>";
	}
	
	
}
?>
<br></br>
<br></br>
</br>
    </div>
	
    </div>
	
<div class="recommendation">
 <h1 style="color:white; font-size:35px; text-align: center; margin-top:-50px; background-color:blue">Crops Recomendation</h1>
    <form style="text-align: center; background-color:#e0ebeb"> <!-- method= post, action="adress from the python server" -->
      <table>
        <tr>
          <th>Temperature</th>
          <td><input type="number" name="temperature" required></td>
        </tr>
        <tr>
          <th>Humidity</th>
          <td><input type="number" name="humidity" required></td>
        </tr>
        <tr>
          <th>Nitrogen (N)</th>
          <td><input type="number" name="nitrogen" required></td>
        </tr>
        <tr>
          <th>Phosphorus (P)</th>
          <td><input type="number" name="phosphorus" required></td>
        </tr>
        <tr>
          <th>Potassium (K)</th>
          <td><input type="number" name="potassium" required></td>
        </tr>
        <tr>
          <th>pH</th>
          <td><input type="number" name="ph" required></td>
        </tr>
        <tr>
          <th>Rainfall</th>
          <td><input type="number" name="rainfall" required></td>
        </tr>
        <tr>
          <td colspan="2"><input type="submit" value="Submit"></td>
        </tr>
      </table>
    </form>
    </div>
	
	    <div class="col-sm">
         <div class="right">
      <h1 style="color:white; font-size:35px; text-align: center; margin-top:-50px; background-color:gray">About</h1>
      <p style="background-color:#99B8A4" >Smart irrigation system uses weather data, humidity and soil moisture data to determine the irrigation need of the soil. This method maximizes irrigation efficiency by reducing water waste, while maintaining plant health and quality. Incorporating smart irrigation technology can potentially reduce outdoor water consumption. Soil moisture sensor in the system measures actual moisture content of the soil. 
        It then adjusts the time of irrigation water based on this data. It can scientifically judge whether to water plants and how much to water based on the current regional weather data and soil moisture conditions. If you want to manually turn on the motor then it can be done with the help of a button.
      </p> 
    </div>
	
    </div>
	

	
  </div>
</div>
</div>



<script type="text/javascript">
    //clock
      function updateClock(){
      var now = new Date();
      var dname = now.getDay(),
          mo = now.getMonth(),
          dnum = now.getDate(),
          yr = now.getFullYear(),
          hou = now.getHours(),
          min = now.getMinutes(),
          sec = now.getSeconds(),
          pe = "AM";

          if(hou >= 12){
            pe = "PM";
          }
          if(hou == 0){
            hou = 12;
          }
          if(hou > 12){
            hou = hou - 12;
          }

          Number.prototype.pad = function(digits){
            for(var n = this.toString(); n.length < digits; n = 0 + n);
            return n;
          }

          var months = ["January", "February", "March", "April", "May", "June", "July", "Augest", "September", "October", "November", "December"];
          var week = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
          var ids = ["dayname", "month", "daynum", "year", "hour", "minutes", "seconds", "period"];
          var values = [week[dname], months[mo], dnum.pad(2), yr, hou.pad(2), min.pad(2), sec.pad(2), pe];
		  
          for(var i = 0; i < ids.length; i++)
          document.getElementById(ids[i]).firstChild.nodeValue = values[i];
    }

    function initClock(){
      updateClock();
      window.setInterval("updateClock()", 1);
    }

  </script>

<footer class="bg-dark text-center text-lg-start"><div class="text-center p-3" style="background-color: rgba(255, 255, 255, 0.2);">© 2023 Copyright:<a class="text-green" href="#">IOT Smart Irrigation System</a></div></footer>
</body>
<script>
$.ajaxSetup({timeout:1000});
btn1 = document.querySelector('input[name="butname"]');
btn3 = document.querySelector('input[name="butname2"]');
btn1.addEventListener('click', feeder)
btn3.addEventListener('click', motor)


function feeder()
{
	console.log("pump clicked");
	var val1 = 'CM';
	if (btn1.value === 'Turn OFF') 
	{
	btn1.value = 'Turn ON';
	val1 = 'CM';
	} 
	else 
	{
     btn1.value = 'Turn OFF';
	val1 = 'OM';	}
	TextVar = "<?php echo $ip?>";
	ArduinoVar = "http://" + TextVar + ":80/";
	$.get( ArduinoVar, {led: val1})	;
	{Connection: close}
}


function motor()
{
	var pump = 'OFF';
	var val1 = 'CP';
	if (btn3.value === 'Turn OFF') 

	{
console.log("Trun OFF");
	btn3.value = 'Turn ON';
	val1 = 'CP';
	pump = 'OFF';
	} 
	else 
	{
		console.log("Trun ON");
    	btn3.value = 'Turn OFF';
	val1 = 'OP';
	pump = 'ON';

	}
	TextVar = "<?php echo $ip?>";
	ArduinoVar = "http://" + TextVar + ":80/";
	$.get( ArduinoVar, {led: val1})	;
	{Connection: close}
}


</script>

</html>

