#!/bin/bash
set -vx
chmod 4755 /sbin/iptables ##设置iptables的权限，使nginx www-data用户可以调用 

dnsipA=192.168.1.1 ##DNSA
disipB=192.168.1.100 ##DNSB

default_rule(){
        #默认允许访问dns。
            dns_rule=`iptables -L FORWARD -n|grep dpt:53|wc -l`
            if [ ${dns_rule} -lt 2 ];then
                iptables -I FORWARD -i eth1 -d ${dnsipA} -p udp --dport 53 -j ACCEPT  #允许DNS通过
                iptables -I FORWARD -i eth1 -d ${dnsipB} -p udp --dport 53 -j ACCEPT  #允许DNS通过
            fi
        #添加默认的drop规则
            drop_rule=`iptables -L FORWARD -n|egrep "^DROP"|grep "all" |grep "0.0.0.0/0"|wc -l`
            if [ ${drop_rule} -lt 1 ];then
                iptables -A FORWARD -i eth1 -j DROP  #默认禁止一切forward规则
            fi
}


delete_rule(){
        #清除forward中所有规则
            iptables -F FORWARD
}

delete_rule;
default_rule;
/sbin/iptables -L FORWARD -n

mv /var/lib/dhcp/dhcpd.leases /var/lib/dhcp/dhcpd.leases_bak
/etc/init.d/isc-dhcp-server restart

date
