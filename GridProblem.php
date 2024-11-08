<?php
	
	if($_POST){
		$grid_count 			= $_POST['grid_count'];
		$player_count 			= $_POST['player_count'];
		$max_position 		    = $grid_count * $grid_count;
		$max_position_counter   = 0;
		$player_array = [];

		for($v = 1; $v <= $player_count; $v++) {
			$player_array[] = [
				'player_current_dice' => 0,
				'player_current_position' => 0,
				'player_current_coordinate' => '',
				'player_dice' => [],
				'player_position' => [],
				'player_coordinate' => [],
				'winner' => false
			];
		}
		$winner_found = false;

		while (true) {			
			foreach ($player_array as $key => &$value) {
				$dice = rand(6,1);

				array_push($value['player_dice'], $dice);
				$value['player_current_dice'] = $dice;
				
				$position_counter = 0;
				$position_found = false;
				for($i = 0;$i < $grid_count;$i++){
					if($i % 2 == 0 ){
						for ($j = 0; $j < $grid_count; $j++) { 
							// echo '<pre>';
							// echo $j.','.$i;
							// echo '<pre>';
							$position_counter = $position_counter +1;
							// echo $position_counter;

							if($dice + $value['player_current_position'] == $position_counter){
								if($position_counter > $max_position){
									$value['player_current_position'] = $value['player_current_position'];
									$value['player_current_coordinate'] = $value['player_current_coordinate'];
								}else{
									$value['player_current_position'] = $position_counter;
									$value['player_current_coordinate'] = "($j,$i)";
									if($max_position_counter <= $position_counter){
										$max_position_counter = $position_counter;
									}
								}
								$position_found = true;
								break;
							}

						}
					}else{
						for ($j = $grid_count -1 ; $j >= 0 ; $j--) { 
							
							$position_counter = $position_counter + 1;
							if($dice + $value['player_current_position'] == $position_counter){
								if($position_counter > $max_position){
									$value['player_current_position'] = $value['player_current_position'];
									$value['player_current_coordinate'] = $value['player_current_coordinate'];
								}else{
									if($max_position_counter <= $position_counter){
										$max_position_counter = $position_counter;
									}
									$value['player_current_position'] = $position_counter;
									$value['player_current_coordinate'] = "($j,$i)";
								}
								$position_found = true;
								break;
							}
						}
					}
					if($position_found == true){
						break;
					}
				}
					
				array_push($value['player_position'],$value['player_current_position']);
				array_push($value['player_coordinate'],$value['player_current_coordinate']);

				if($value['player_current_position'] == $max_position){
					$value['winner'] = true;
					$winner_found = true;
					break;
				}
			}

			if($winner_found === true){
				break;
			}
		}
		
	}else{
		$player_array = [];
	}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Grid Winner</title>
</head>
<body>

	<div>
		<span>User Input</span>
		<form method="post">
			<label>Grid</label>
			<input type="text" name="grid_count" required>
			<input type="submit" name="start" value="START">
			<label>Players</label>
			<input type="text" name="player_count" value="3">
		</form>
	</div>
	<div>
		<table border="1" width="auto">
			<thead>
				<th>Player No.</th>
				<th>Dice Roll History</th>
				<th>Position History</th>
				<th>Coordinate History</th>
				<th>Winner Status</th>
			</thead>
			<?php foreach ($player_array as $k => $val) { ?>
				<tbody>
					<td> <?php echo $k+1; ?> </td>
					<td><?php echo implode(',',$val['player_dice']); ?></td>
					<td><?php echo implode(',',$val['player_position']); ?></td>
					<td><?php echo implode(',',$val['player_coordinate']); ?></td>
					<td><?php echo $val['winner'] === true ? 'Winner':''; ?></td>
				</tbody>
			<?php } ?>
		</table>
	</div>
</body>
</html>
