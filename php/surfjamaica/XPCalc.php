<?php
	//Minecraft Online XP Calculator
	//Author: Surfjamaica
	function calculateWholeXP($i){
		$low = $i;
		$mid = max(0,$i-15);
		$high = max(0,$i-30);
		return $low*17+($mid*($mid-1)/2)*3+($high*($high-1)/2)*7;
	}

	function calculateXP($i){
		$whole = floor($i);
		$partial = $i-$whole;

		$wholeXP = calculateWholeXP($whole);
		$nextXP = calculateWholeXP($whole + 1) - $wholeXP;
		$partialXP = $nextXP * $partial;

		return $wholeXP + $partialXP;
	}

	function calculate($i,$j){
		return calculateXP($j)-calculateXP($i);
	}


	$required = 0;
	$errorReport = "";
	if(isset($_POST['submitcalc'])) {
		$currentLevel = $_POST['currentl'];
		$wantedLevel = $_POST['wanted'];

		$errors = 'Errors occured: <br />';

		if(isset($currentLevel) && isset($wantedLevel) && is_numeric($currentLevel) && is_numeric($wantedLevel)){
			//Tests passed. Lets go on with the things.
			if(($currentLevel > 9998) || ($wantedLevel > 9999)) {
				//Add Error Report (Levels too high)
				$errors .= '&middot;Specified levels too high.<br />';
			} elseif ($currentLevel > $wantedLevel) {
				//Can't calculate downwards.
				$errors .= '&middot;Can\'t calculate downwards.<br />';
			} elseif ($currentLevel < $wantedLevel) {
				$required = ceil(calculate($currentLevel,$wantedLevel));
			} else {
				//Some undefined error happened.
				$errors .= '&middot;Undefined error occured.<br />';
			}

		} else {
			//The code failed and stuff.
			$errors .= '&middotThe text fields either aren\'t set, or aren\'t numbers<br />';
		}
		if(strlen($errors) > 35) {
			$errorReport = "<div class=\"error\">".$errors."</div>";
		}
	}
?>
<html>
	<head>
		<style type="text/css">
			body{
				padding: 0px;
				margin: 0px;
				margin-top: 20px;
				background: #005b85;
			}
			.conWrapper {
				width: 220px;
				margin: auto;
			}
			.conForm {
				text-align: center;
				background: #009cc3;
				border-radius: 10px;
				width: 220px;
				color: #FFFFFF;
				font-weight: bold;
				font-family: Arial, Helvetica, Sans-Serif;
			}
			.conForm .content {
				padding: 10px;
			}
			.conForm .head {
				width: auto;
				padding: 8px;
				padding-top: 10px;
				background: #007896;
				border-top-left-radius: inherit;
				border-top-right-radius: inherit;
			}
			.conForm .error {
				width: auto;
				background: #ff3333;
				border: 2px solid #a60000;
				border-radius: 5px;
				text-align: left;
				font-size: 12px;
				padding: 4px;
			}

		</style>
		<title>Minecraft XP Calculator</title>
	</head>
	<body>
		<div class="conWrapper">
			<div class="conForm">
				<div class="head">
					Minecraft XP Calculator
				</div>
				<div class="content">
					<form name="calculator" id="calculator" method="POST" action="">
						Enter values below<br />
						<?php 
						echo $errorReport;
						?>
						Current Level: <input type="text" name="currentl" size="3" maxlength="4"><br />
						Wanted Level: <input type="text" name="wanted" maxlength="4" size="3"><br />
						<input type="submit" name="submitcalc" id="submitcalc" value="Calculate XP!"><br />
						XP Required = <?php echo $required; ?><br />
						<font size="2" color="lightgray">Made by Surfjamaica</font>
					</form>
				</div>
			</div>
		</div>
	</body>
</html>