<?php
session_start();

require_once "dbconfig.in.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST["email"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM users WHERE email = :email";
    $stmt=$pdo ->prepare($sql);
    $stmt->bindParam(":email", $email);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);
      if ($user && password_verify($password, $user["password"])) {

        $_SESSION["user_id"] = $user["id"];
        $_SESSION["name"] = $user["name"];
        $_SESSION["email"] = $user["email"];
        $_SESSION["user_type"] = $user["user_type"];

        header("Location: ticketsys.php");
        exit();

    } else {

        $error = "Invalid email or password.";

    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login - Maintenance Request System</title>
</head>

<body>

<header>
    <img src="images/logo.jpg" alt="Maintenance Request System Logo">
    <h1>Maintenance Request System</h1>
</header>

<main>
    <h2>Login</h2>
<?php
if ($error != "") {
    echo "<p>" . $error . "</p>";
}
?>
    <form action="login.php" method="post">

        <div>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email"
                   placeholder="Enter your email" required>
        </div>

        <div>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password"
                   placeholder="Enter your password" required>
        </div>

        <div>
            <button type="submit">Login</button>
        </div>

    </form>
</main>

<footer>
    <p>Contact Us Page | +970 2 295 6786</p>
    <p>Email: info@maintenance.com</p>
    <p>5th Floor Al-Nahda Building, Jaffa Street, Ramallah, Palestine</p>
    <p>&copy; 2026 Baraa Darraj - ID: 1230667 | <a href="../../index.html">Baraa Darraj Home Page</a></p>
</footer>

</body>
</html>
