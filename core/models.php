<?php  

function checkIfUserExists($pdo, $username) {
	$response = array();
	$sql = "SELECT * FROM user_accounts WHERE username = ?";
	$stmt = $pdo->prepare($sql);

	if ($stmt->execute([$username])) {

		$userInfoArray = $stmt->fetch();

		if ($stmt->rowCount() > 0) {
			$response = array(
				"result"=> true,
				"status" => "200",
				"userInfoArray" => $userInfoArray
			);
		}

		else {
			$response = array(
				"result"=> false,
				"status" => "400",
				"message"=> "User doesn't exist from the database"
			);
		}
	}

	return $response;

}



function insertNewUser($pdo, $username, $first_name, $last_name, $password) {
	$response = array();
	$checkIfUserExists = checkIfUserExists($pdo, $username); 

	if (!$checkIfUserExists['result']) {

		$sql = "INSERT INTO user_accounts (username, first_name, last_name, password) 
		VALUES (?,?,?,?)";

		$stmt = $pdo->prepare($sql);

		if ($stmt->execute([$username, $first_name, $last_name, $password])) {
			$response = array(
				"status" => "200",
				"message" => "User successfully inserted!"
			);
		}

		else {
			$response = array(
				"status" => "400",
				"message" => "An error occured with the query!"
			);
		}
	}

	else {
		$response = array(
			"status" => "400",
			"message" => "User already exists!"
		);
	}

	return $response;
}




function getAllUsers($pdo) {
	$sql = "SELECT * FROM users
			ORDER BY PilotName ASC";
	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute();
	if ($executeQuery) {
		return $stmt->fetchAll();
	}
}

function getUserByID($pdo, $id) {
	$sql = "SELECT * from users WHERE id = ?";
	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute([$id]);

	if ($executeQuery) {
		return $stmt->fetch();
	}
}

function searchForAUser($pdo, $searchQuery) {
	
	$sql = "SELECT * FROM users WHERE 
			CONCAT(PilotName,DateOfBirth,Email,PhoneNumber,
				LicenseNumber,SubmissionDate) 
			LIKE ?";

	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute(["%".$searchQuery."%"]);
	if ($executeQuery) {
		return $stmt->fetchAll();
	}
}

function insertAnActivityLog($pdo, $operation, $id, $PilotName, 
		$Email, $PhoneNumber, $username) {

	$sql = "INSERT INTO activity_logs (operation, id, PilotName, 
		Email, PhoneNumber, username) VALUES(?,?,?,?,?,?)";

	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute([$operation, $id, $PilotName, 
		$Email, $PhoneNumber, $username]);

	if ($executeQuery) {
		return true;
	}

}

function getAllActivityLogs($pdo) {
	$sql = "SELECT * FROM activity_logs 
			ORDER BY SubmissionDate DESC";
	$stmt = $pdo->prepare($sql);
	if ($stmt->execute()) {
		return $stmt->fetchAll();
	}
}

function insertNewUsers($pdo, $PilotName, $DateOfBirth, $Email, 
	$PhoneNumber, $LicenseNumber) {

	$sql = "INSERT INTO users
			(
				PilotName,
				DateOfBirth,
				Email,
				PhoneNumber,
				LicenseNumber
			)
			VALUES (?,?,?,?,?)
			";

	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute([
		$PilotName, $DateOfBirth, $Email, 
		$PhoneNumber, $LicenseNumber
	]);

	if ($executeQuery) {
		$findInsertedItemSQL = "SELECT * FROM users ORDER BY SubmissionDate DESC LIMIT 1";
		$stmtfindInsertedItemSQL = $pdo->prepare($findInsertedItemSQL);
		$stmtfindInsertedItemSQL->execute();
		$getID = $stmtfindInsertedItemSQL->fetch();

		$insertAnActivityLog = insertAnActivityLog($pdo, "INSERT", $getID['id'], 
			$getID['PilotName'], $getID['Email'], 
			$getID['PhoneNumber'], $_SESSION['username']);

		if ($insertAnActivityLog) {
			$response = array(
				"status" =>"200",
				"message"=>"User addedd successfully!"
			);
		}

		else {
			$response = array(
				"status" =>"400",
				"message"=>"Insertion of activity log failed!"
			);
		}
		
	}

	else {
		$response = array(
			"status" =>"400",
			"message"=>"Insertion of data failed!"
		);

	}

	return $response;
}


function editUser ($pdo, $PilotName, $DateOfBirth, $Email, $PhoneNumber, 
	$LicenseNumber, $id) {

	$sql = "UPDATE users
				SET PilotName = ?,
					DateOfBirth = ?,
					Email = ?,
					PhoneNumber = ?,
					LicenseNumber = ?
				WHERE id = ? 
			";

	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute([$PilotName, $DateOfBirth, $Email, $PhoneNumber, 
		$LicenseNumber, $id]);

		if ($executeQuery) {

			$findInsertedItemSQL = "SELECT * FROM users WHERE id = ?";
			$stmtfindInsertedItemSQL = $pdo->prepare($findInsertedItemSQL);
			$stmtfindInsertedItemSQL->execute([$id]);
			$getID = $stmtfindInsertedItemSQL->fetch(); 
	
			$insertAnActivityLog = insertAnActivityLog($pdo, "INSERT", $getID['id'], 
			$getID['PilotName'], $getID['Email'], 
			$getID['PhoneNumber'], $_SESSION['username']);

		if ($insertAnActivityLog) {
			$response = array(
				"status" =>"200",
				"message"=>"User addedd successfully!"
			);
		}
	
			else {
				$response = array(
					"status" =>"400",
					"message"=>"Insertion of activity log failed!"
				);
			}
	
		}
	
		else {
			$response = array(
				"status" =>"400",
				"message"=>"An error has occured with the query!"
			);
		}
	
		return $response;
	
	}

function deleteUser($pdo, $id) {
	$sql = "DELETE FROM users
			WHERE id = ?";
	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute([$id]);

	if ($executeQuery) {
		return true;
	}
}


function getAllUserss($pdo) {
	$sql = "SELECT * FROM user_accounts";
	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute();

	if ($executeQuery) {
		return $stmt->fetchAll();
	}
}
?>
