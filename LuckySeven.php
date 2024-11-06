<?php 

	$dice1 = '';
	$dice2 = '';
	$total_dice = '';
	if($_POST){
		if(isset($_POST['resetplay']) && $_POST['resetplay'] == 'Continue Playing'){
			$balance = $_POST['balance'];
			$message = 'Your balance is '.$balance.' Rs';
		}
		elseif(isset($_POST['resetplay']) && $_POST['resetplay'] == 'Reset and Play Again'){
			$balance = 100;
			$message = 'Your balance is '.$balance.' Rs';
		}else {
			$balance = $_POST['balance'];
			if($balance >0){
				$bet 		= $_POST['bet'];
				$bet_value 	= 10;
				$dice1 		= rand(1,6);
				$dice2 		= rand(1,6);
				$total_dice = $dice1 + $dice2;
				$bet_win 	= false;
				switch ($bet) {
					case 'below_seven':
						if($total_dice < 7){
							$balance = $balance + $bet_value * 2 - $bet_value;
							$bet_win = true;
						}
						break;
					case 'seven':
						if($total_dice == 7){
							$balance = $balance + $bet_value * 3 - $bet_value;
							$bet_win = true;
						}
						break;
					case 'above_seven':
						if($total_dice > 7){
							$balance = $balance + $bet_value * 2 - $bet_value;
							$bet_win = true;
						}
						break;
					default:
						// code...
						break;
				}

				if($bet_win == true){
					$message = 'Congratulations! You win! Your balance is now '.$balance.' Rs';
				}else{
					$balance = $balance - $bet_value;
					$message = 'Bad Luck! You Loose! Your balance is now '.$balance.' Rs';
				}
			}else{
				$balance = 0;
				$message = "Your balance is $balance Rs.You can't place bet.";
			}
		}
	}else{
		$balance = 100;
		$message = "Your balance is $balance Rs.";
	}
		
?>

	<html>
		<title>Lucky Seven</title>

		<body>
			<h1>Welcome to Lucky 7 game.</h1>
			<div>
				
				<label>Place Your Bet (Rs 10):</label>
				<form method="post">
					<input type="radio" id="b7" name="bet" value="below_seven" required>
					<label for="b7" >Below 7</label>
					<input type="radio" id="7" name="bet" value="seven" required>
					<label for="7">7</label>
					<input type="radio" id="a7" name="bet" value="above_seven" required>
					<label for="a7">Above 7</label>
					<input type="hidden" name="balance" value="<?php echo $balance; ?>">
					<input type="submit" name="submit" value="play">
				</form>
			</div>
			<div>
				<label>Game Results</label>
				<p>Dice 1: <?php echo $dice1; ?></p>
				<p>Dice 2: <?php echo $dice2; ?></p>
				<p>Total: <?php echo $total_dice; ?></p>
			</div>
			<div>
				<label><?php echo $message; ?></label>
			</div>
			<div>
				<form method="post">
					<input type="submit" name="resetplay" value="Reset and Play Again">
					<input type="hidden" name="balance" value="<?php echo $balance; ?>">
					<input type="submit" name="resetplay" value="Continue Playing">
				</form>
			</div>
		</body>
	</html>
