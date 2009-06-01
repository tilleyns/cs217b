<?php
$script="plus_minus_".$_GET["date"].".js";
$func=$_GET['func'].str_replace("-","_",$_GET["date"]);

?>

<!DOCTYPE html "-//W3C//DTD XHTML 1.0 Strict//EN" 
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <title>BGP</title>
    <script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=ABQIAAAA_O2q_21TrwaqT0ryJaPmVhRFhBUpW6p0A43AJXjPFoHY0d0GIRQv_ibsFETPF12Hf4q4CNBgD4N3bw&sensor=false"
			type="text/javascript"></script>
	<script src="bordersOverlay.js"></script>
	<script src="<?= $script?>"></script>
 <script type="text/javascript">

	var map;
    function initialize() {
      if (GBrowserIsCompatible()) {
        map = new GMap2(document.getElementById("map_canvas"));
        map.setCenter(new GLatLng(40.4419, 0.1419), 2);
	//	map.setUIToDefault();
		map.setMapType(G_NORMAL_MAP);

		initBorders();
		addBordersOverlay();
<?php
		
		print	$func."();\n";
?>
      }
    }

    </script>
  </head>
  <body onload="initialize()" onunload="GUnload()" style="margin:0">
 <div id="map_canvas" style="/*width: 2200px; height: 1300px*/width:100%;height:100%"></div>
  </body>
</html>

