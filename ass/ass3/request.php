<?php

session_start();
require_once "dbconfig.in.php";
if (!isset($_SESSION["user_id"])) {

    header("Location: login.php");
    exit();

}
if ($_SESSION["user_type"] != "customer") {

    header("Location: ticketsys.php");
    exit();

}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $customer_id = $_SESSION["user_id"];
    $customer_name = $_SESSION["name"];
    $email = $_POST["email"];
    $location = $_POST["location"];
    $description = $_POST["description"];
    $emergency_level = $_POST["urgency"];

    $status = "Pending";
    $assigned_date = NULL;
    $assigned_staff = NULL;
    $image_name = NULL;

$sql = "INSERT INTO tickets (customer_id,customer_name,email,location,description,submitted_date,status,emergency_level,
                assigned_date,
                assigned_staff,
                image_name
            )
            VALUES(:customer_id,:customer_name,:email,:location,:description,NOW(),
                :status,
                :emergency_level,
                :assigned_date,
                :assigned_staff,
                :image_name
            )";

    $stmt = $pdo->prepare($sql);

    $stmt->bindParam(":customer_id", $customer_id);
    $stmt->bindParam(":customer_name", $customer_name);
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":location", $location);
    $stmt->bindParam(":description", $description);
    $stmt->bindParam(":status", $status);
    $stmt->bindParam(":emergency_level", $emergency_level);
    $stmt->bindParam(":assigned_date", $assigned_date);
    $stmt->bindParam(":assigned_staff", $assigned_staff);
    $stmt->bindParam(":image_name", $image_name);
    $stmt->execute();

    $ticket_id = $pdo->lastInsertId();

    if (isset($_FILES["photo"]) && $_FILES["photo"]["error"] == 0) {
        $file_type = $_FILES["photo"]["type"];
        if ($file_type != "image/jpeg") {
            echo "<p>Only JPEG images are allowed.</p>";
            exit();
        }
        $image_name = $ticket_id . ".jpeg";
        $image_path ="images/" . $image_name;
        move_uploaded_file($_FILES["photo"]["tmp_name"],$image_path);
        $sql = "UPDATE tickets SET image_name = :image_name WHERE ticket_id = :ticket_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(
            ":image_name",
            $image_name
        );
        $stmt->bindParam(
            ":ticket_id",
            $ticket_id
        );
        $stmt->execute();
    }

    $_SESSION["new_ticket_id"] = $ticket_id;
    header("Location: confirm.php");
    exit();

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
        <title>Maintenance Request System</title>
        <link rel="stylesheet" href="style.css">
</head>

<body>
<header class="site-header">
    <div class="header-container">

        <img class="site-logo" src="images/logo.jpg" alt="Maintenance Request System Logo">

        <h1>Maintenance Request System</h1>
        <div class="user-info">
        <?php echo $_SESSION["name"]; ?>
       <span class="user-role">
        (<?php echo ucfirst($_SESSION["user_type"]); ?>)
    </span>
</div>
        <nav>
            <ul>
                <li><a href="ticketsys.php">Home</a></li>
                <li><a href="request.php">Submit Maintenance Request</a></li>
            </ul>
        </nav>

    </div>
</header>
<main class="request-page">

    <h2 class="page-title">
        Submit Maintenance Request
    </h2>

    <p class="welcome-message">
        Welcome <?php echo $_SESSION["name"]; ?>
    </p>
    <hr>
<form action="request.php" method="post" enctype="multipart/form-data" class="request-form">
     <div class="form-group">
      <label for="name">Full Name:</label>
      <input type="text" name="name" id="name" placeholder="Enter your name" value="<?php echo $_SESSION["name"]; ?>" disabled>
</div>
      <div class="form-group">
      <label for="email">Email Address:</label>
      <input type="email" name="email" id="email" placeholder="Enter your email" required>
</div>
      <div class="form-group">
        <label for="location">Location/Room Number:</label>
        <input type="text" name="location" id="location" placeholder="Enter the room or Location">
</div>

    <div class="form-group">
        <label for="description">Issue Description:</label>
        <textarea name="description" id="description" rows="5" cols="30" placeholder="Describe the Issue"></textarea>   
</div>

    <div class="form-group">
       <label for="urgency">Urgency Level:</label>
       <select name="urgency" id="urgency">
        <option value="Low">Low</option>
       <option value="Medium">Medium</option>
       <option value="High">High</option>
       </select>   
</div>
    <div class="form-group">
    <label for="photo">Upload a Photo of the Issue (optional):</label>
    <input type="file" name="photo" id="photo">
</div>
    <div class="form-group">
    <input type="submit" value="Submit Request" class="btn btn-primary">
</div>
   </form>
</main>
<footer>

    <div class="footer-contact">
        <p>
            <a href="contact.php">Contact Us</a>
            | +970 2 295 6786
        </p>

        <p>Email: info@maintenance.com</p>

        <address>
            5th Floor Al-Nahda Building, Jaffa Street,
            Ramallah, Palestine
        </address>
    </div>

    <div class="footer-copyright">
        <p>
            &copy; 2026 Baraa Darraj - ID: 1230667
        </p>

        <a href="../../index.html">
            Baraa Darraj Home Page
        </a>
    </div>

</footer>
</body>
</html>
