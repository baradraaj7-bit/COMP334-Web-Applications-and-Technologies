<?php

session_start();
require_once 'dbconfig.in.php';
 
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
if (!isset($_SESSION["new_ticket_id"])) {
    header("Location: ticketsys.php");
    exit();
}
$ticket_id = $_SESSION["new_ticket_id"];
unset($_SESSION["new_ticket_id"]);
require_once "Ticket.php";

$sql = "SELECT * FROM tickets 
        WHERE ticket_id = :ticket_id";

$stmt = $pdo->prepare($sql);

$stmt->bindParam(":ticket_id", $ticket_id);

$stmt->execute();

$ticket = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$ticket) {
    echo "<p>Invalid ticket ID.</p>";
    exit();
}

$ticketObject = new Ticket(
    $ticket["ticket_id"],
    $ticket["customer_name"],
    $ticket["email"],
    $ticket["location"],
    $ticket["description"],
    $ticket["submitted_date"],
    $ticket["status"],
    $ticket["emergency_level"],
    $ticket["assigned_date"],
    $ticket["assigned_staff"],
    $ticket["image_name"]
);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Request Confirmation</title>
</head>
<body>
<header>
    <img src="images/logo.jpg" alt="Maintenance Request System Logo">
    <h1>Maintenance Request System</h1>
    <nav>
        <ul>
            <li><a href="ticketsys.php">Home</a></li>
            <li><a href="customer.php">My Tickets</a></li>
            <li><a href="request.php">Submit Maintenance Request</a></li>
    </nav>
</header>
<main>
    <p>
        Welcome <?php echo $_SESSION["name"]; ?>
    </p>
    <hr>
    <h2>
        Maintenance Request Submitted Successfully
    </h2>
  <p>
    Dear <?php echo $ticket['customer_name']; ?>, thank you for submitting your
    maintenance request. Your ticket has been created in the system with reference number is
    <strong><?php echo $ticket['ticket_id']; ?></strong>.
</p>
    <p>Here is a summary of the information we have received:</p>
    <?php echo $ticketObject->displayTicketPage(); ?> 
    <p>Our maintenance team will respond to your request shortly.</p>
</main>
 <footer>
    <p>Contact Us Page | +970 2 295 6786</p>
    <p>Email: info@maintenance.com</p>
    <p>5th Floor Al-Nahda Building, Jaffa Street, Ramallah, Palestine</p>
    <p>&copy; 2026 Baraa Darraj - ID: 1230667 |  <a href="../../index.html">Baraa Darraj Home Page</a></p>
</footer>
</body>
</html>
