# wifi-auth

----原理----

依赖 https://github.com/intern/PHP-QR-Code

1.本PHP认证接口放在运行了dhcpd的GUEST-WIFI接入网关上
2.调用iptables实现mac地址的放行

----INSTALL----

1.先把整个项目放在GUEST-WIFI网关的nginx+php或者apache+php环境中，如放在/var/www/wifi-auth中，则使用 http://guest-domain/wifi-auth/ 访问
2.先用root帐号执行scripts/reset_fw.sh，初始化一次网关的防火墙规则

----手机认证过程----

1.访客手机访问 http://guest-domain/wifi-auth/ ，生成二维码
2.使用员工手机扫描第1步生成的二维码
3.通过认证后，访客手机则可以上网了
4.更多的规则可通过修改auth/openfw.php达到目的

----安全----
为了防止通过认证的访客手机也可以认证另外的访客手机，最好在nginx/apache加入IP验证，屏蔽GUEST-WIFI网段进行认证：
<code>
  location ~ /auth/ {
                    allow 192.168.0.0/16;
                    deny all;
  }
  </code>
