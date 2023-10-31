<?php
$transactionServername = "localhost:3307";
$transactionUsername = "root";
$transactionPassword = ""; // Replace with your actual MySQL password for the transaction_db
$transactionDbname = "transaction_db";

$transactionConn = new mysqli($transactionServername, $transactionUsername, $transactionPassword, $transactionDbname);

if ($transactionConn->connect_error) {
    die("Connection to the transaction database failed: " . $transactionConn->connect_error);
}

$sql = "SELECT studentname, courses, sdate, item, confirmed_by, quantity FROM transaction_db.transactionstable WHERE status = '1'";
$result = $transactionConn->query($sql);

if ($result) {
    $transactionsGrouped = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $key = $row["studentname"] . $row["courses"] . $row["sdate"];

            if (!isset($transactionsGrouped[$key])) {
                $transactionsGrouped[$key] = [
                    "studentname" => $row["studentname"],
                    "courses" => $row["courses"],
                    "sdate" => $row["sdate"],
                    "transactions" => [],
                    "confirmed_by" => $row["confirmed_by"],
                ];
            }

            $transactionsGrouped[$key]["transactions"][] = [
                "item" => $row["item"],
                "quantity" => $row["quantity"],
            ];
        }

        $html = '';

        foreach ($transactionsGrouped as $transaction) {
            $html .= "<h2>Name: " . $transaction["studentname"] . "</h2>";
            $html .= "<p>Course: " . $transaction["courses"] . "</p>";
            $html .= "<p>Date: " . $transaction["sdate"] . "</p>";
            $html .= "<p>Confirmed By: " . $transaction["confirmed_by"] . "</p>";
            $html .= "<p>Item List:</p><ul>";

            foreach ($transaction["transactions"] as $transactionItem) {
                $html .= "<li>Item: " . $transactionItem["item"] . " - Quantity: " . $transactionItem["quantity"] . "</li>";
            }

            $html .= "</ul>";
        }

        echo $html;
    } else {
        echo "No confirmed transactions found.";
    }

    $result->close();
} else {
    echo "Error retrieving confirmed transactions: " . $transactionConn->error;
}

$transactionConn->close();
?>
