<html>
    <head>
        <title>Kalender</title>
    </head>
        <style>
        #box {
                margin: 3vw;
                padding: 3vw;
                box-sizing: border-box;
                display: inline-block;
                border: 1px solid black;
                text-align: center;
                
        }
		h1,h2,h3,h4,h5,h6,p {
			margin:0
		}
    </style>
    
    <body>
        <h1>Membuat Kalender</h1>
		<p>Agung Satrio Budi Prakoso (XI-RPL2 SMKN 4 Bandung)</p><hr>
        <form method="post" action="#">
			<tr>
                <td>Tahun</td>
                <td><input name="tahun" type="number" min=1></td>
            </tr>
            
            <tr>
                <td><button type="submit">Masukkan</button><td>
            </tr>
        </form>
		<hr>
    </body>
</html>

<?php 
$y = isset($_POST['tahun'])?$_POST['tahun']:date("Y");


make_calendar($y,3);

function make_calendar($y,$banjar) {
	echo "<h1 style='text-align:center'> Kalender $y</h1>";
	echo "<table border=1 style='margin: 0 auto'><tr>";
    for($i=1; $i<=12; $i++) {
		echo "<td style='padding:10px'>";
		calendarPerMonth($y, $i);
		echo "</td>";
		if($i%$banjar==0) echo "</tr><tr>";
    }
	echo "</table>";
}

function calendarPerMonth($y, $m) {
	$bulan = array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
	$hari = array("Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu");
	$day_props = makeDay($y,$m);
	$box_count = daysInMonth($y,$m) + $day_props['serial_day'];
	$caption=0;
	$k=1;
	
	echo "<h2>{$bulan[$m-1]} $y</h2>";
	echo "<table border=1>";
	
	echo "<tr>";
    for($i=1; $i<=count($hari); $i++) {
		echo "<td style='padding:3px'>{$hari[$i-1]}</td>";
		if($i==count($hari)) echo "</tr>";
    }  
	
	for($i=1; $i<=42; $i++) {
		if($i<=$box_count) {
			if($i<=$day_props['serial_day']) {
				$j = (daysInMonth($y,$m-1) - $day_props['serial_day']) + $i;
				echo "<td style='color:gray'>$j</td>";
			} else if($i>=$day_props['serial_day']) {
				$caption++;
				if($i%7==1) echo "<td style='color:red'><b>$caption</b></td>"; else echo "<td><b>$caption</b></td>";
				
			} 
		} else if($i>$box_count) {
			echo "<td style='color:gray'>$k</td>";
			$k++;
		}
		if($i%7==0) echo "</tr><tr>";
    }
	echo "</table>";
}
	
function daysInmonth($y,$m) { //short version
	return 28+($m<8?($m%2==0?($m==2?($y%4==0&&$y%100!=0&&$y%400!=0?1:0):2):3):($m%2==0?3:2));
}

function makeDay($y, $m, $adjust=null) {
	$serial=0;
	for($j=1;$j<$y;$j++) $serial += ($j%4==0&&$y%100!=0&&$y%400!=0?366:365);
	for($i=1;$i<$m;$i++) $serial += $adjust!=null?$adjust:daysInMonth($y, $i);
	return array("serial"=>$serial,"serial_day"=>$serial%7);
}

?>