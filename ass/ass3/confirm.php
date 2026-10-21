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
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header class="site-header">
    <div class="header-container">

        <img class="site-logo"
             src="images/logo.jpg"
             alt="Maintenance Request System Logo">

        <h1>Maintenance Request System</h1>

        <nav>
            <ul>
                <li><a href="ticketsys.php">Home</a></li>
                <li><a href="customer.php">My Tickets</a></li>
                <li><a href="request.php">Submit Maintenance Request</a></li>
            </ul>
        </nav>

    </div>
</header>
<main class="confirmation-page">

    <p class="welcome-message">
        Welcome <?php echo $_SESSION["name"]; ?>
    </p>

    <div class="confirmation-card">

        <h2 class="confirmation-title">
            Maintenance Request Submitted Successfully
        </h2>

        <p>
            Dear <?php echo $ticket['customer_name']; ?>,
            thank you for submitting your maintenance request.
        </p>

        <p>
            Your ticket has been created in the system with
            reference number
            <strong class="ticket-id">
                <?php echo $ticket['ticket_id']; ?>
            </strong>.
        </p>

        <p>
            Here is a summary of the information we have received:
        </p>

        <?php echo $ticketObject->displayTicketPage(); ?>

        <p class="confirmation-message">
            Our maintenance team will respond to your request shortly.
        </p>

        <a href="customer.php" class="btn btn-primary">
            View My Tickets
        </a>

    </div>

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
