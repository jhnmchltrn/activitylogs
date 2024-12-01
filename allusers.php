<?php  
require_once 'core/models.php'; 
require_once 'core/handleForms.php'; 

if (!isset($_SESSION['username'])) {
	header("Location: login.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
    <style>
		body {
			font-family: Arial, sans-serif;
			background-color: #f4f4f4;
			margin: 0;
			padding: 20px;
		}
		h2 {
			color: #333;
		}
		ul {
			list-style-type: none;
			padding: 0;
		}
		li {
			background: #fff;
			margin: 5px 0;
			padding: 10px;
			border-radius: 5px;
			box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
		}
		nav {
			background-color: #333;
			color: white;
			padding: 10px;
			margin-bottom: 20px;
		}
		nav a {
			color: white;
			text-decoration: none;
			margin: 0 15px;
		}
		nav a:hover {
			text-decoration: underline;
		}
	</style>
</head>
<body>
	<?php include 'navbar.php'; ?>
	<h2>All Users</h2>
	<ul>
		<?php $getAllUserss = getAllUserss($pdo);?>
		<?php foreach ($getAllUserss as $row) { ?>
			<li><?php echo $row['username']; ?></li>
		<?php } ?>
	</ul>
</body>
</html>