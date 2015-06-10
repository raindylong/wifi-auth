<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="cache-control" content="no-cache" />
<title>简悦wifi验证系统</title>
</head>
<body bgcolor=green>
<h1>

<center>==EJOY-GUEST 认证结果==</center>
<?php
    $ip=$_REQUEST['ip'];
    if (strlen($ip) > 15){ die(); }

    $mac = shell_exec("cat /var/lib/dhcp/dhcpd.leases|sed -n '/".$ip."/,+6 p' |sed -n '/hardware ethernet/ p'|tail -1|cut -d' ' -f5|sed 's/;//g'");	
    $mac = trim(preg_replace('/\s\s+/', ' ', $mac));
    $mac = str_replace(array("\n", "\r"), '', $mac);
    echo "MAC地址：$mac";
    echo "<br/>IP地址：$ip";
    echo "&nbsp;<hr/>已通过验证,本周内有效。";
    // echo "iptables -I FORWARD -m mac --mac-source ".$mac." -j ACCEPT";
    system("iptables -I FORWARD -m mac --mac-source ".$mac." -j ACCEPT");
// iptables -I FORWARD -p tcp -d 172.16.0.0/16  -m mac --mac-source "C4:6A:B7:48:0B:C1" -j DROP 
    system("iptables -I FORWARD -p tcp -d 172.16.0.0/16 -m mac --mac-source ".$mac." -j DROP");
?>

</body>
