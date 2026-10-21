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
</head>

<body>
<header>
    <img src="images/logo.jpg" alt="Maintenance Request System Logo">
    <h1>Maintenance Request System</h1>
     <ul>
        <li><a href="login.php">Home</a></li>
        <li><a href="request.php">Submit Maintenance Request</a></li>
    </ul>
</header>
<main>
<p>
        Welcome <?php echo $_SESSION["name"]; ?>
    </p>
    <hr>
<form action="request.php" method="post" enctype="multipart/form-data">
     <p>
      <label for="name">Full Name:</label>
      <input type="text" name="name" id="name" placeholder="Enter your name" value="<?php echo $_SESSION["name"]; ?>" disabled>
      </p>
      <p>
      <label for="email">Email Address:</label>
      <input type="email" name="email" id="email" placeholder="Enter your email" required>
      </p>
      <p>
        <label for="Location">Location/Room Number:</label>
        <input type="text" name="location" id="location" placeholder="Enter the room or Location">
      </p>

    <p>
        <label for="Description">Issue Description:</label>
        <textarea name="description" id="description" rows="5" cols="30" placeholder="Describe the Issue"></textarea>      </p>

    <p>
       <label for="Level">Urgency Level:</label>
       <select name="urgency" id="Level">
        <option value="Low">Low</option>
       <option value="Medium">Medium</option>
       <option value="High">High</option>
       </select>   
    </p>
    <p>
    <label for="Photo">Upload a Photo of the Issue (optional):</label>
    <input type="file" name="photo" id="Photo">
    </p>
    <p>
    <input type="submit" value="Submit Request">
    </p>
   </form>
</main>
<footer>
    <p>Contact Us Page | +970 2 295 6786</p>
    <p>Email: info@maintenance.com</p>
    <p>5th Floor Al-Nahda Building, Jaffa Street, Ramallah, Palestine</p>
    <p>&copy; 2026 Baraa Darraj - ID: 1230667 |  <a href="../../index.html">Baraa Darraj Home Page</a></p>
</footer>
</body>
</html>
