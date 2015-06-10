<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="cache-control" content="no-cache" />
<title>简悦wifi验证系统</title>
<style>
  #center{
    display: inline-block;
    position: absolute;
    left: 10%;
    top: 10%;
  }
</style>
</head>
<body bgcolor=green>
<div id="center">
<?php
function getRealIpAddr()
{
  if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
    {
      $ip=$_SERVER['HTTP_CLIENT_IP'];
    }
  elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
    {
      $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
    }
  else
    {
      $ip=$_SERVER['REMOTE_ADDR'];
    }
  return $ip;
}
$ip=getRealIpAddr();
$wifidomain="radius.ejoy.com";
$guest_id = time();
echo "<center><h1>简悦WIFI二维码验证系统</h1></center>";
echo "<h1>请找管理员扫描通过验证<br>GUEST_ID:$guest_id<br>";
$url="http://$wifidomain/auth/openfw.php?ip=".$ip;

    //set it to writable location, a place for temp generated PNG files
    $PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'temp/'.DIRECTORY_SEPARATOR.$guest_id;
    
    //html PNG location prefix
    $PNG_WEB_DIR = 'temp/';

    include "qrlib.php";    
    
    //ofcourse we need rights to create temp dir
/*
    if (!file_exists($PNG_TEMP_DIR))
        mkdir($PNG_TEMP_DIR);
*/
    
    
//    $filename = $PNG_TEMP_DIR.'test.png';
    

    $errorCorrectionLevel = 'L';

    $matrixPointSize = 4;


        $filename = $PNG_TEMP_DIR.'qr_'.$ip."_".md5($guest_id.'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';
        QRcode::png($url, $filename, $errorCorrectionLevel, $matrixPointSize, 2);    
        
    //display generated file
    echo '<img width=90% src="'.$PNG_WEB_DIR.basename($filename).'" /><hr/>';  
   echo "<h1>mac地址:";
   system("sed -n '/".$ip."/,+7 p' /var/lib/dhcp/dhcpd.leases|grep hardware|tail -1");
   echo "<hr/>";
   echo "<h1>IP地址:".$ip;
   echo "<hr/>";
//   echo "认证地址:".$url;
?>
</div>
</body>
</html>
