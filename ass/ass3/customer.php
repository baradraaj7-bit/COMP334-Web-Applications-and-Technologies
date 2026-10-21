<?php

session_start();

require_once "dbconfig.in.php";
require_once "Ticket.php";
if (!isset($_SESSION["user_id"])) {

    header("Location: login.php");
    exit();

}

if ($_SESSION["user_type"] != "customer") {

    header("Location: ticketsys.php");
    exit();

}

$customer_id = $_SESSION["user_id"];

$sql = "SELECT *FROM tickets WHERE customer_id = :customer_id";
$params = [":customer_id" => $customer_id];
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (!empty($_POST["description"])) {
        $sql .= " AND description LIKE :description";
        $params[":description"] ="%" . $_POST["description"] . "%";
    }

    if (!empty($_POST["submitDate"])) {

        $sql .= " AND DATE(submitted_date) = :submitDate";
        $params[":submitDate"] = $_POST["submitDate"];
    }

    if (isset($_POST["status"]) && $_POST["status"] != "all") {
        $sql .= " AND status = :status";
        $params[":status"] =$_POST["status"];
    }

    if (isset($_POST["urgency"]) && $_POST["urgency"] != "all") {
        $sql .= " AND emergency_level = :urgency";
        $params[":urgency"] =$_POST["urgency"];
    }
}
$stmt = $pdo->prepare($sql);

$stmt->execute($params);

$tickets = $stmt->fetchAll(PDO::FETCH_ASSOC);
$ticketObjects = [];

foreach ($tickets as $ticket) {
    $ticketObjects[] = new Ticket(

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
}
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
                <li><a href="customer.php">My Tickets</a></li>
                <li><a href="request.php">Submit Request</a></li>
            </ul>
        </nav>
    </div>
</header>
<main class="customer-page">

    <h2 class="page-title">
    Welcome <?php echo $_SESSION["name"]; ?>
</h2>

<div class="customer-dashboard">

    <section class="dashboard-section">

        <h3 class="section-title">Search / Filter Tickets</h3>

        <form method="post" action="customer.php" class="filter-form">
        <fieldset>
            <legend>Advanced Ticket Search</legend>
            <div class="filter-group">
            <label for="description">Description:</label>
            <input type="text" name="description" id="description" placeholder="Search.." />
</div>
<div class="filter-group">
            <label for="submitDate">Submission Date:</label>
            <input type="date" name="submitDate" id="submitDate" />
</div>
<div class="filter-group">
            <label for="status">Status:</label>
            <select name="status" id="status">
               <option value="all">All</option>
               <option value="Pending">Pending</option>
               <option value="Active">Active</option>
               <option value="Completed">Completed</option>
            </select>
</div>
<div class="filter-group">
            <label for="urgency">Emergency Level:</label>
            <select name="urgency" id="urgency">
                <option value="all">All</option>
                <option value="High">High</option>
                <option value="Medium">Medium</option>
                <option value="Low">Low</option>
            </select>
</div>
            <input type="submit" value="Filter" class="btn btn-primary" />
        </fieldset>
           </form>

    </section>

    <section class="dashboard-section">

        <h3 class="section-title">Ticket List</h3>

        <table class="tickets-table">
  
        <thead>
            <tr>
                <th scope="col">Ticket ID</th>
                <th scope="col">Issue Description</th>
                <th scope="col">Date Submitted</th>
                <th scope="col">Customer Name</th>
                <th scope="col">Urgency Level</th>
                <th scope="col">Status</th>
                <th scope="col">Ticket Action</th>
            </tr>
        </thead> 
        <tbody>
          <?php foreach ($ticketObjects as $ticket) { ?>
         <?php echo $ticket->displayTable(); ?>

<?php } ?>  

    </tbody>
    </table>
  </section>

</div>
    <hr/>
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