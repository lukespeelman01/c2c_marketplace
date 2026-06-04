<?php
session_start();

$message = "";
$message_type = "";
$ticket = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $request = isset($_POST['message']) ? trim($_POST['message']) : '';

    if (empty($email) || empty($request)) {
        $message = "Please fill in all fields.";
        $message_type = "error";
    } else {

        //Generate fake ticket number
        $ticket = rand(1000, 9999);

        //Simulate sending email (no real email)
        $message = "Request sent! Ticket #: $ticket (confirmation sent to $email)";
        $message_type = "success";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Help & Support</title>

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .box {
            background-color: #ffffff;
            padding: 30px;
            width: 360px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            text-align: center;
        }

        h2 {
            margin-top: 0;
            margin-bottom: 20px;
        }

        input, textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 6px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        textarea {
            height: 120px;
            resize: none;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #FFF8E1;
            border: none;
            border-radius: 6px;
            font-weight: bold;
            cursor: pointer;
        }

        button:hover {
            background-color: #FFF3CD;
        }

        .message {
            margin-top: 10px;
            font-weight: bold;
        }

        .message.success {
            color: green;
        }

        .message.error {
            color: red;
        }

        a {
            display: block;
            margin-top: 15px;
            text-decoration: none;
            color: black;
            font-weight: bold;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>

<div class="box">

    <h2>Help & Support</h2>

    <!--FORM -->
    <form method="POST">
        <input type="email" name="email" placeholder="Enter your email" required>

        <textarea name="message" placeholder="Describe your problem..." required></textarea>

        <button type="submit">Send Request</button>
    </form>

    <!--MESSAGE -->
    <div class="message <?php echo $message_type; ?>">
        <?php echo $message; ?>
    </div>

    <!--BACK LINK -->
    <a href="C2C Marketplace.php">Back to Marketplace</a>

</div>

</body>
</html>