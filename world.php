<?php
$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);

// Check if a country name is provided in the query string
if (isset($_GET['country'])) {
    $countryName = $_GET['country'];

    // Escape the input to prevent SQL injection
    $countryName = $conn->quote("%$countryName%"); // Use quote to safely handle input

    // Query the database to get information about the country
    $stmt = $conn->query("SELECT name, capital, region, head_of_state FROM countries WHERE name LIKE $countryName");

    // Fetch the result as an associative array
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    // If the country is found, return it as JSON
    if ($result) {
        echo json_encode($result);
    } else {
        // If no country is found, return an error message
        echo json_encode(["error" => "No country found with that name."]);
    }
} else {
    // If no country parameter is provided, return an error message
    echo json_encode(["error" => "Please enter a country name."]);
}

$conn = null; // Close the database connection
?>
