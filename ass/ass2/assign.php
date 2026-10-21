<?php

session_start();

require_once "dbconfig.in.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

if ($_SESSION["user_type"] != "manager") {
    header("Location: ticketsys.php");
    exit();
}

if (!isset($_GET["id"]) && $_SERVER["REQUEST_METHOD"] != "POST") {
    echo "<p>Invalid ticket ID.</p>";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $ticket_id = $_POST["ticket_id"];
    $staff_id = $_POST["staff_id"];

    $sql = "SELECT name FROM users
            WHERE id = :staff_id
            AND user_type = :user_type";

    $stmt = $pdo->prepare($sql);

    $user_type = "staff";

    $stmt->bindParam(":staff_id", $staff_id);
    $stmt->bindParam(":user_type", $user_type);

    $stmt->execute();

    $staff = $stmt->fetch(PDO::FETCH_ASSOC);


    if (!$staff) {
        echo "<p>Invalid staff member.</p>";
        exit();
    }
    $sql = "UPDATE tickets
            SET status = :status,
                assigned_staff = :assigned_staff,
                assigned_date = NOW()
            WHERE ticket_id = :ticket_id";

    $stmt = $pdo->prepare($sql);

    $status = "Active";
    $assigned_staff = $staff["name"];

    $stmt->bindParam(":status", $status);
    $stmt->bindParam(":assigned_staff", $assigned_staff);
    $stmt->bindParam(":ticket_id", $ticket_id);

    $stmt->execute();


    $_SESSION["assign_message"] = "Ticket assigned successfully.";

    header("Location: view.php?id=" . $ticket_id);
    exit();
}

$ticket_id = $_GET["id"];

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

if ($ticket["assigned_staff"] != NULL ||
    $ticket["status"] == "Completed") {

    $_SESSION["assign_message"] =
        "This ticket has already been assigned or completed.";

    header("Location: view.php?id=" . $ticket_id);
    exit();
}

$sql = "SELECT id, name FROM users
        WHERE user_type = :user_type";

$stmt = $pdo->prepare($sql);

$user_type = "staff";

$stmt->bindParam(":user_type", $user_type);

$stmt->execute();

$staffMembers = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Assign Ticket</title>
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

    <p>
        Welcome <?php echo $_SESSION["name"]; ?>
    </p>


    <h2>
        Assign Ticket <?php echo $ticket["ticket_id"]; ?>
    </h2>


    <p>
        <strong>Issue Description:</strong>
        <?php echo $ticket["description"]; ?>
    </p>


    <p>
        <strong>Urgency Level:</strong>
        <?php echo $ticket["emergency_level"]; ?>
    </p>


    <p>
        <strong>Date Submitted:</strong>
        <?php echo $ticket["submitted_date"]; ?>
    </p>


    <form action="assign.php" method="post">
        <input type="hidden"
               name="ticket_id"
               value="<?php echo $ticket["ticket_id"]; ?>">


        <label for="staff">
            Assign to Staff Member:
        </label>
        <select name="staff_id" id="staff" required>
            <option value="">
                Select Staff Member
            </option>

            <?php foreach ($staffMembers as $staff) { ?>

                <option value="<?php echo $staff["id"]; ?>">

                    <?php echo $staff["name"]; ?>

                </option>

            <?php } ?>

        </select>

        <br><br>

        <input type="submit" value="Assign Ticket">

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