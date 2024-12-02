<?php
$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);

$country = isset($_GET['country']) ? $_GET['country'] : '';
$lookup = isset($_GET['lookup']) ? $_GET['lookup'] : '';

if ($lookup === 'cities') {
    $query = "SELECT cities.name, cities.district, cities.population
              FROM cities
              JOIN countries ON cities.country_code = countries.code
              WHERE countries.name LIKE :country";
    $stmt = $conn->prepare($query);
    $stmt->bindValue(':country', "%$country%", PDO::PARAM_STR);
    $stmt->execute();
    $cities = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($cities) {
        echo json_encode(['cities' => $cities]);
    } else {
        echo json_encode(['error' => 'No cities found for the given country']);
    }
    exit;
}

$query = "SELECT name, capital, region, head_of_state FROM countries WHERE name LIKE :country";
$stmt = $conn->prepare($query);
$stmt->bindValue(':country', "%$country%", PDO::PARAM_STR);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($results) {
    echo json_encode($results[0]); 
} else {
    echo json_encode(['error' => 'No countries found matching your search']);
}
?>