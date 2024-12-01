<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .greeting {
            background-color: #007BFF;
            color: white;
            padding: 20px;
            text-align: center;
        }

        .greeting h1 {
            margin: 0;
        }

        .navbar {
            background-color: #333;
            overflow: hidden;
        }

        .navbar h3 {
            margin: 0;
            padding: 14px 16px;
        }

        .navbar a {
            float: left;
            display: block;
            color: white;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }

        .navbar a:hover {
            background-color: #575757;
            transition: background-color 0.3s;
        }

        .navbar a:active {
            background-color: #4CAF50; /* Active link color */
        }
    </style>
</head>
<body>

<div class="greeting">
    <h1>Hello there! Welcome, <span style="color: yellow;"><?php echo $_SESSION['username']; ?></span></h1>
</div>

<div class="navbar">
    <h3>
        <a href="index.php">Home</a>
        <a href="insert.php">Add New </a>
        <a href="allusers.php">All Users</a>
        <a href="activitylogs.php">Activity Logs</a>
        <a href="core/handleForms.php?logoutUserBtn=1">Logout</a> 
    </h3>  
</div>

</body>
</html>