<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $mac = escapeshellarg($_POST['mac']);
    $dhcp_type = escapeshellarg($_POST['dhcp_type']);

    $command = escapeshellcmd("python3 network_config.py $mac $dhcp_type");
    $output = shell_exec($command);
    
    $response = json_decode($output, true);

    if ($response) {
        echo "<h2>Assigned IP Address</h2>";
        echo "<p>MAC Address: " . htmlspecialchars($response['mac']) . "</p>";
        echo "<p>Assigned IP: " . htmlspecialchars($response['ip']) . "</p>";
        echo "<p>Subnet: " . htmlspecialchars($response['subnet']) . "</p>";
        if (isset($response['lease_time'])) {
            echo "<p>Lease Time: " . htmlspecialchars($response['lease_time']) . " seconds</p>";
        }
    } else {
        echo "<p>Error processing request.</p>";
    }
} else {
    echo "<p>Invalid request.</p>";
}
?>