<?php
	session_start();
	$totalPizza = 0;
?>

<!DOCTYPE html>
<html>
<head>
	<title>CheckOut</title>
	<link rel="stylesheet" type="text/css" href="mystyle.css">
</head>
<body background="background1.jpg">
		<?php
		$conn = mysqli_connect('localhost','root', '', 'pizzastore');
		if ( !$conn ) {
				die("Connection failed: " .mysqli_connect_error());      /* Establish connection with database */
		}




		for ($i=0; $i < count($_SESSION['pizzaSession']); $i++) {


			$sizeTemp = $_SESSION['pizzaSession'][$i];

			$sqlSize = "SELECT Size, Price FROM pizza WHERE Picture = '$sizeTemp'";
			$size = mysqli_query($conn, $sqlSize);
			$row = mysqli_fetch_array($size, MYSQLI_ASSOC);
			echo '<div style: "text-align: center;">', "<img src=".$_SESSION['pizzaSession'][$i].">", '<br>', '<span>The size of the pizza is: </span>', $row["Size"], '<br>', "<span>The price of the pizza is: </span>"
			, $row["Price"], '<br>', "<span>The number of this pizza ordered is: </span>", $_SESSION['pizzaNum'][$i], '</div>';
			$totalPizza = $totalPizza + ($_SESSION['pizzaNum'][$i] * $row["Price"]);


			echo "<img src=".$_SESSION['sauce'][$i].">";

			echo "<br>";
		}

		echo "The total price is: " ,$totalPizza;
		$_SESSION['totalPrice'] = $totalPizza;
		?>












	<h1>Please enter the required information to process your order:</h1>







	<form method="post" action="<?php echo $_SERVER["PHP_SELF"];?>" style="text-align: center;">
		<label for="firstName">First Name:</label>
		<input type="text" name="FirstName" id="firstName"> <br>
		<label for="lastName">Last Name:</label>
		<input type="text" name="LastName" id="lastName"> <br>
		<label for="email">Email:</label>
		<input type="email" name="Email" id="email" style="margin-left: 31px;"> <br>
		<input type="submit" name="submit" value="Confirm">
	</form>

	<?php
		// define variables and set to empty values
		$firstName = $lastName = $firstf = $firstff = $lastf = $laftff = "";

		if ($_SERVER["REQUEST_METHOD"] == "POST") {
  			$firstName = $_POST["FirstName"];
  			$_SESSION['firstName'] = $firstName;
			$lastName = $_POST["LastName"];
			$_SESSION['lastName'] = $lastName;

			$checkFirst = "SELECT GivenName FROM customer WHERE GivenName = '$firstName'";
			$checkLast = "SELECT GivenName FROM customer WHERE LastName = '$lastName'";
			$firstf = mysqli_query($conn, $checkFirst);
			$lastf = mysqli_query($conn, $checkLast);
			$firstff = mysqli_fetch_array($firstf, MYSQLI_ASSOC);
			$lastff = mysqli_fetch_array($lastf, MYSQLI_ASSOC);
			if ($firstName == NULL || $firstff == NULL || $lastName == NULL || $lastff == NULL) {
				echo '<p style="text-align: center; color: red;">The information you provided does not match with our database!</p>';
				return false;
			} else {
				header("Location: confirm.php");

			}

		}





?>

</html>
