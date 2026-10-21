<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require_once "dbconfig.in.php";
require_once "Ticket.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

if ($_SESSION["user_type"] != "manager") {
    header("Location: ticketsys.php");
    exit();
}
$sql = "SELECT * FROM tickets WHERE 1=1";
$params = [];
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (!empty($_POST["description"])) {
        $sql .= " AND description LIKE :description";
        $params[":description"] = "%" . $_POST["description"] . "%";
    }

    if (!empty($_POST["name"])) {
        $sql .= " AND customer_name LIKE :name";
        $params[":name"] = "%" . $_POST["name"] . "%";
    }

    if (!empty($_POST["submitDate"])) {
        $sql .= " AND DATE(submitted_date) = :submitDate";
        $params[":submitDate"] = $_POST["submitDate"];
    }

    if (isset($_POST["status"]) && $_POST["status"] != "all") {
        $sql .= " AND status = :status";
        $params[":status"] = $_POST["status"];
    }

    if (isset($_POST["urgency"]) && $_POST["urgency"] != "all") {
        $sql .= " AND emergency_level = :urgency";
        $params[":urgency"] = $_POST["urgency"];
    }

} else {
    $sql .= " AND status = :status AND assigned_staff IS NULL";
    $params[":status"] = "Pending";
}


$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$tickets = $stmt->fetchAll(PDO::FETCH_ASSOC);


$ticketObjects = [];

foreach ($tickets as $ticket) {

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

    $ticketObjects[] = $ticketObject;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Maintenance Request System</title>

</head>
<body>
 <header>
    <img src="images/logo.jpg" alt="Maintenance Request System Logo">
    <h1>Maintenance Request System</h1>
    <nav>
    <ul>
        <li><a href="ticketsys.php">Home</a></li>
        <li><a href="manager.php">View Tickets</a></li>
    </ul>
</nav>
</header>

<main>
<h2>Welecome <?php echo $_SESSION["name"]; ?> </h2>
<hr/>
<form method="post" action="manager.php">
        <fieldset>
            <legend>Advanced Ticket Search</legend>
 
            <label for="description">Description:</label>
            <input type="text" name="description" id="description" placeholder="Search.." />
 
             <label for="name">Customer Name:</label>
             <input type="text" name="name" id="name" placeholder="Search by name.." />

            <label for="submitDate">Submission Date:</label>
            <input type="date" name="submitDate" id="submitDate" />
 
            <label for="status">Status:</label>
            <select name="status" id="status">
               <option value="all">All</option>
               <option value="Pending">Pending</option>
               <option value="Active">Active</option>
               <option value="Completed">Completed</option>
            </select>
 
            <label for="urgency">Emergency Level:</label>
            <select name="urgency" id="urgency">
                <option value="all">All</option>
                <option value="High">High</option>
                <option value="Medium">Medium</option>
                <option value="Low">Low</option>
            </select>
 
            <input type="submit" value="Filter" />
        </fieldset>
    </form>
 
    <h3>Ticket List</h3>
    <table border="1">
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
 
    <hr />
</main>
<footer>
    <p>Contact Us Page | +970 2 295 6786</p>
    <p>Email: info@maintenance.com</p>
    <p>5th Floor Al-Nahda Building, Jaffa Street, Ramallah, Palestine</p>
    <p>&copy; 2026 Baraa Darraj - ID: 1230667 |  <a href="../../index.html">Baraa Darraj Home Page</a></p>
</footer>
</body>
</html>