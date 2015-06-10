#!/bin/bash

sed -n "/$1/,+7 p" /var/lib/dhcp/dhcpd.leases|grep hardware|tail -1
