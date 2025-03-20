<?php
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Assignment 8 Felipe Camargo</title>

    <style>
    * {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    input[type='number'] {
        appearance: textfield;
        -moz-appearance: textfield;
    }

    .container {
        display: flex;
        flex-direction: column;
        gap: 12px;
        padding: 24px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.4);
        max-width: fit-content;
        margin: 50px auto;
        border-radius: 8px;
    }

    .container input {
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    .container input:focus {
        outline: none;
        border-color: #abf755;
    }

    .container label {
        font-weight: bold;
        font-size: 28px;
    }

    .container button {
        padding: 0.5rem 0.25rem;
        border: none;
        background-color: #007bff;
        color: white;
        border-radius: 0.4rem;
        cursor: pointer;
    }

    .container button:hover {
        background-color: #0056b3;
    }
    </style>
</head>

<body>
    <h2>Request an IP Address</h2>
    <form action="process.php" method="post">
        <label for="mac">MAC Address:</label>
        <input type="text" id="mac" name="mac" required pattern="^([0-9A-Fa-f]{2}[:-]){5}([0-9A-Fa-f]{2})$">
        <br><br>

        <label for="dhcp_type">DHCP Version:</label>
        <select id="dhcp_type" name="dhcp_type">
            <option value="dhcpv4">DHCPv4</option>
            <option value="dhcpv6">DHCPv6</option>
        </select>
        <br><br>

        <input type="submit" value="Request IP">
    </form>
</body>

</html>