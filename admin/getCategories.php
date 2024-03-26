<?php
include('../connection.php');

$sql = "SELECT * FROM categories";
$result = mysqli_query($conn, $sql);

$categories = [];
while ($row = mysqli_fetch_assoc($result)) {
    $categories[] = [
        'id' => $row['id'],
        'name' => $row['name']
    ];
}

echo json_encode($categories);

mysqli_close($conn);
?>
