<?php
include('../config.php');

$limit = 5; // Number of courses per page
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Fetch courses with LIMIT and OFFSET for pagination
$sql = "SELECT courses.*, users.name as instructor_name FROM courses 
        JOIN users ON courses.instructor_id = users.id
        LIMIT $limit OFFSET $offset";
$result = $conn->query($sql);

// Fetch total number of courses
$count_sql = "SELECT COUNT(*) as total_courses FROM courses";
$count_result = $conn->query($count_sql);
$total_courses = $count_result->fetch_assoc()['total_courses'];
$total_pages = ceil($total_courses / $limit);

// Display courses
if ($result->num_rows > 0) {
    echo "<h1>All Courses</h1>";
    while($course = $result->fetch_assoc()) {
        echo "<div>";
        echo "<h2>" . $course['title'] . "</h2>";
        echo "<p>Instructor: " . $course['instructor_name'] . "</p>";
        echo "<p>Price: $" . $course['price'] . "</p>";
        echo "<a href='details.php?id=" . $course['id'] . "'>View Details</a>";
        echo "</div>";
    }

    // Display pagination
    echo "<div class='pagination'>";
    for ($i = 1; $i <= $total_pages; $i++) {
        echo "<a href='index.php?page=$i'>$i</a> ";
    }
    echo "</div>";
} else {
    echo "No courses available.";
}
?>

