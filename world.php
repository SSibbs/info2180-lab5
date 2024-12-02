<?php
$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);

$country = isset($_GET['country']) ? $_GET['country'] : '';

$query = "SELECT name, continent, independence_year, head_of_state FROM countries WHERE name LIKE :country";
$stmt = $conn->prepare($query);

$stmt->bindValue(':country', "%$country%", PDO::PARAM_STR);

$stmt->execute();

$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Country Lookup</title>
    <link href="world.css" type="text/css" rel="stylesheet" />
</head>
<body>

    <header>
        <h1>World Database Lookup</h1>
    </header>

    <main>
        <h2>Search Results for: <?php echo htmlspecialchars($country); ?></h2>

        <table>
            <thead>
                <tr>
                    <th>Country Name</th>
                    <th>Continent</th>
                    <th>Independence Year</th>
                    <th>Head of State</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($results): ?>
                    <?php foreach ($results as $row): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                            <td><?php echo htmlspecialchars($row['continent']); ?></td>
                            <td><?php echo htmlspecialchars($row['independence_year']); ?></td>
                            <td><?php echo htmlspecialchars($row['head_of_state']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4">No countries found matching your search.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </main>

</body>
</html>

