import sys
import json
import re
import random
import ipaddress

DHCPv4_SUBNET = "192.168.1.0/24"
DHCPv6_SUBNET = "2001:db8::/64"

lease_db = {}

def is_valid_mac(mac):
    return re.match(r"^([0-9A-Fa-f]{2}[:-]){5}([0-9A-Fa-f]{2})$", mac) is not None

def generate_ipv4():
    subnet = ipaddress.IPv4Network(DHCPv4_SUBNET, strict=False)
    while True:
        ip = str(random.choice(list(subnet.hosts())))
        if ip not in lease_db.values():
            return ip

def generate_ipv6(mac):
    parts = mac.split(":")
    parts[0] = "%02x" % (int(parts[0], 16) ^ 2) 
    eui64 = ":".join(parts[:3] + ["ff:fe"] + parts[3:])
    return f"{DHCPv6_SUBNET[:-3]}{eui64}"

def assign_ip(mac, dhcp_type):
    if mac in lease_db:
        assigned_ip = lease_db[mac]
    else:
        if dhcp_type == "dhcpv4":
            assigned_ip = generate_ipv4()
        else:
            assigned_ip = generate_ipv6(mac)
        lease_db[mac] = assigned_ip

    return assigned_ip

def main():
    if len(sys.argv) != 3:
        print(json.dumps({"error": "Invalid input"}))
        sys.exit(1)

    mac = sys.argv[1]
    dhcp_type = sys.argv[2].lower()

    if not is_valid_mac(mac):
        print(json.dumps({"error": "Invalid MAC address format"}))
        sys.exit(1)

    assigned_ip = assign_ip(mac, dhcp_type)
    response = {
        "mac": mac,
        "ip": assigned_ip,
        "subnet": DHCPv4_SUBNET if dhcp_type == "dhcpv4" else DHCPv6_SUBNET
    }

    if dhcp_type == "dhcpv4":
        response["lease_time"] = 3600 

    print(json.dumps(response))

if __name__ == "__main__":
    main()
