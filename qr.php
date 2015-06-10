<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="cache-control" content="no-cache" />
<title>GUEST-WIFI验证系统</title>
<style>
  #center{
    display: inline-block;
    position: absolute;
    left: 10%;
    top: 10%;
  }
</style>
</head>
<body>
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
$wifidomain="wifi.xxx.com";
$url="http://$wifidomain/index.php";

    //set it to writable location, a place for temp generated PNG files
    $PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR;
    
    //html PNG location prefix
    $PNG_WEB_DIR = 'temp/';

    include "qrlib.php";    
    
    //ofcourse we need rights to create temp dir
    if (!file_exists($PNG_TEMP_DIR))
        mkdir($PNG_TEMP_DIR);
    
    
    $filename = $PNG_TEMP_DIR.'test.png';
    

    $errorCorrectionLevel = 'L';

    $matrixPointSize = 4;


        $filename = $PNG_TEMP_DIR.'test'.md5($_REQUEST['data'].'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';
        QRcode::png($url, $filename, $errorCorrectionLevel, $matrixPointSize, 2);    
        
    //display generated file
    echo '<img src="'.$PNG_WEB_DIR.basename($filename).'" /><hr/>';  
//   echo "mac地址:";
//   system("sed -n '/".$ip."/,+7 p' /var/lib/dhcp/dhcpd.leases|grep hardware|head -1");
//   echo "<hr/>";
//   echo "IP地址:".$ip;
//   echo "<hr/>";
//   echo "认证地址:".$url;
?>
</div>
</body>
</html>
