<?php
session_start();
require_once "dbconfig.in.php";
require_once "Ticket.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET["id"])) {
    echo "<p>Invalid ticket ID.</p>";
    exit();
}

$id = $_GET["id"];

$sql = "SELECT * FROM tickets WHERE ticket_id = :id";

$stmt = $pdo->prepare($sql);

$stmt->bindParam(":id", $id);

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
    <meta charset="utf-8" />
    <title>Maintenance Request System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header class="site-header">
    <div class="header-container">

        <img class="site-logo"
             src="images/logo.jpg"
             alt="Maintenance Request System Logo">

        <h1>Maintenance Request System</h1>
        <div class="user-info">
        <?php echo $_SESSION["name"]; ?>
        <span class="user-role">
        (<?php echo ucfirst($_SESSION["user_type"]); ?>)
    </span>
</div>
        <nav>
            <ul>

                <li>
                    <a href="ticketsys.php">Home</a>
                </li>

                <?php if ($_SESSION["user_type"] == "manager") { ?>

                    <li>
                        <a href="manager.php">View Tickets</a>
                    </li>

                <?php } elseif ($_SESSION["user_type"] == "customer") { ?>

                    <li>
                        <a href="customer.php">My Tickets</a>
                    </li>

                    <li>
                        <a href="request.php">Submit Request</a>
                    </li>

                <?php } ?>

            </ul>
        </nav>

    </div>
</header>

<main class="view-page">

    <h2 class="page-title">
        Welcome <?php echo $_SESSION["name"]; ?>
    </h2>

    <hr>

    <?php echo $ticketObject->displayTicketPage(); ?>

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
