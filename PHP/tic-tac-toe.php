<?
// Функция вывода содержимого переменной -> $code(var) и описания переменной -> $description(string)
function debug($code, $description){
	$code = (string)var_export($code, true);
	$rTrash = array("array (\n", ",\n)");
	$code = str_replace($rTrash, "", $code);
	echo "<div id=\"debugFrame\" style=\"position: relative; width: 80%; margin: 10px auto; border: 2px solid #ffd391; overflow: hidden;\"><div class=\"ddescription\" style=\"display: inline-block; vertical-align: top; max-width: 150px; padding: 10px 30px; background-color: #ffd391; padding-bottom: 100%; margin-bottom: -100%;\">" . $description . "</div><div class=\"dresult\" style=\"display: inline-block; white-space: pre-line; padding: 10px; background-color: #fff; padding-right: 99999px; margin-right: -99999px;\">" . $code . "</div></div>";
}

// Функция определения выигрышной комбинации
function winnerWinner_TicTac($user_data){
	if(is_array($user_data)){
		if(in_array(1, $user_data) and in_array(2, $user_data) and in_array(3, $user_data)){
			//echo "first line winner";
			return TRUE;
		}elseif(in_array(4, $user_data) and in_array(5, $user_data) and in_array(6, $user_data)){
			//echo "second line winner";
			return TRUE;
		}elseif(in_array(7, $user_data) and in_array(8, $user_data) and in_array(9, $user_data)){
			//echo "third line winner";
			return TRUE;
		}elseif(in_array(1, $user_data) and in_array(5, $user_data) and in_array(9, $user_data)){
			//echo "from top left to right bottom line winner";
			return TRUE;
		}elseif(in_array(7, $user_data) and in_array(5, $user_data) and in_array(3, $user_data)){
			//echo "from botton left to top right line winner";
			return TRUE;
		}elseif(in_array(1, $user_data) and in_array(4, $user_data) and in_array(7, $user_data)){
			//echo "from botton left to top right line winner";
			return TRUE;
		}elseif(in_array(2, $user_data) and in_array(5, $user_data) and in_array(8, $user_data)){
			//echo "from botton left to top right line winner";
			return TRUE;
		}elseif(in_array(3, $user_data) and in_array(6, $user_data) and in_array(9, $user_data)){
			//echo "from botton left to top right line winner";
			return TRUE;
		}else{
			return FALSE;
		}
	}
}

// Все переменные игры хранится в GET массиве
// Сохранение хода игрока
$_GET["previousSteps"] .= $_GET["game"];
// Определение общего количества шагов игроков
$previousSteps = $_GET["previousSteps"];
if(strlen($previousSteps) <= 9){
	//echo "Меньше или 9 шагов";
	$gameLIFE = TRUE;
	if(strlen($previousSteps) == 9){$gameLIFE = FALSE;}
// Определение шагов каждого игрока
	
	$previousSteps = preg_split('//', $previousSteps, -1, PREG_SPLIT_NO_EMPTY);
	foreach($previousSteps as $stepNumber => $stepValue){
		if($stepNumber%2 == 0){
			global $firstPlayerChoices;
			$firstPlayerChoices[] = $stepValue;
		}else{
			global $secondPlayerChoices;
			$secondPlayerChoices[] = $stepValue;
		}
	}

  // Проверка шагов игрока на выигрышную комбинацию
  if(winnerWinner_TicTac($firstPlayerChoices)){
  	//echo "1st player win!";
  	++$_GET["firstPlayerWins"];
  	$gameLIFE = FALSE;
  }elseif(winnerWinner_TicTac($secondPlayerChoices)){
  	//echo "2nd player win!";
  	++$_GET["secondPlayerWins"];
  	$gameLIFE = FALSE;
  }
}else{
//	echo "Количество шагов больше возможного";
//	echo "Похоже, что ничья)";
	$gameLIFE = FALSE;
}

//Функция заполнения ячейки на игровом поле
function cellFilling($cellNumber, $firstPlayerChoices, $secondPlayerChoices){
	if(substr_count($_GET['previousSteps'], $cellNumber)){
		if(in_array($cellNumber, $firstPlayerChoices)){echo '<div class="tic"></div>';}				// "КРЕСТИК"
		elseif(in_array($cellNumber, $secondPlayerChoices)){echo '<div class="tac"></div>';}	// "НОЛИК"
		else{echo 'What is going on here???'; var_dump($firstPlayerChoices);}									// Непонятно что
	}
	else{echo "<input type=\"submit\" value=\"$cellNumber\" name=\"game\">";}
}//**

?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title>Tic-tac-toe</title>
	<style>
*{margin: 0;padding: 0;}
html,body{min-width: 100%; min-height: 100%; background-color: #1c1c1c; font-size: 15px;}
html{min-height: 630px;}

h1{font-size: 3rem; text-align: center; font-family: Roboto; color: beige; text-shadow: 1px 2px 7px rgba(150,170,190,0.9); margin-top: 1rem;}

.playngField{width: 405px; height: 405px; margin: 3px auto; background-color: transparent; border-collapse: collapse; }
.gameOVER{display: block; width: 405px; height: 405px; position: absolute; top: 70px; left: 50%; margin-left: -203px; z-index: 5; background-color: rgba(255,255,255,0.5); font-size: 2.5rem; font-style: italic; font-family: Roboto; line-height: 405px; text-align: center; }
tr{}
td{width: 135px; height: 135px; box-sizing: border-box; text-align: center;}


input{display: inline-block; width: 97%; height: 97%; font-size: 0px; background-color: #2a2a2a; border: none; border-radius: 5px; box-shadow: 2px 2px 6px rgba(0, 0, 0, 0.6);}
input:hover{background-color: #444;}

.btnField{width: 405px; margin: 0 auto; text-align: center;}
	a.btn{display: inline-block; font-size: 1.5rem; border-radius: 5px; padding: 8px 32px; text-decoration: none; max-width: max-content; font-family: Roboto; font-weight: bold; background-color: #2a2a2a; color: #f5f5dc;margin: 0px 2px;}
	a.btn:hover{color: #555; background-color: #fef;}

.tic{display: inline-block; width: 97%; height: 97%; box-shadow: 2px 2px 6px rgba(0, 0, 0, 0.6);
	background: transparent url(data:image/png;base64,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) 0 0 no-repeat; background-size: contain;}
.tac{display: inline-block; width: 97%; height: 97%; box-shadow: 2px 2px 6px rgba(0, 0, 0, 0.6);
	background: transparent url(data:image/png;base64,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) 0 0 no-repeat; background-size: contain;}

.scoreTable{
	position: relative;
	max-width: 200px;
	left: 50%;
	margin-left: -90px;
	margin-top: 10px;
	padding: 3px;
	font-size: 0px;
}
.FirstPlayer, .SecondPlayer{
	display: inline-block;
	position: relative;
	width: 90px;
	height: 90px;
	box-sizing: border-box;
	border: 4px solid #616161;
	font-size: 77px;
	color: beige;
	text-align: center;
	line-height: 83px;
	font-family: Roboto;
}
.FirstPlayer{
	background-color: #54b9fe;
	margin-right: 5px;
}
.SecondPlayer{
	background-color: #ef6464;
}
	</style>
</head>
<body>
<!--<?debug($_GET, "Массив GET");?>-->
<h1>Tic-tac-toe</h1>
<?
if(!$gameLIFE){
	echo '<div class="gameOVER">';
		if(winnerWinner_TicTac($firstPlayerChoices)){
			echo "Congrats 1st player win!";
		}elseif(winnerWinner_TicTac($secondPlayerChoices)){
			echo "Congrats 2nd player win!";
		}else{
			echo "Congrats nobody win!";
		}
	echo '</div>';
}
?>
<table class="playngField">
	<form action="" method="GET">
	<tr>
		<td><? cellFilling(1, $firstPlayerChoices, $secondPlayerChoices); ?></td>
		<td><? cellFilling(2, $firstPlayerChoices, $secondPlayerChoices); ?></td>
		<td><? cellFilling(3, $firstPlayerChoices, $secondPlayerChoices); ?></td>
	</tr>
	<tr>
		<td><? cellFilling(4, $firstPlayerChoices, $secondPlayerChoices); ?></td>
		<td><? cellFilling(5, $firstPlayerChoices, $secondPlayerChoices); ?></td>
		<td><? cellFilling(6, $firstPlayerChoices, $secondPlayerChoices); ?></td>
	</tr>
	<tr>
		<td><? cellFilling(7, $firstPlayerChoices, $secondPlayerChoices); ?></td>
		<td><? cellFilling(8, $firstPlayerChoices, $secondPlayerChoices); ?></td>
		<td><? cellFilling(9, $firstPlayerChoices, $secondPlayerChoices); ?>
			<input type="hidden" name="previousSteps" value="<? echo $_GET["previousSteps"]; ?>">
			<input type="hidden" name="firstPlayerWins" value="<? echo $_GET["firstPlayerWins"]; ?>">
			<input type="hidden" name="secondPlayerWins" value="<? echo $_GET["secondPlayerWins"]; ?>">
		</td>
	</tr>
	</form>
</table>

<div class="btnField">
	<a href="http://<? 
	echo $_SERVER['SERVER_NAME'] . $_SERVER['PHP_SELF'] . '?';
	echo 'firstPlayerWins=' . $_GET["firstPlayerWins"] . '&';
	echo 'secondPlayerWins=' . $_GET["secondPlayerWins"];
	?>" alt="RESET" class="btn">RESET</a>
	<a href="http://<? 
	echo $_SERVER['SERVER_NAME'] . $_SERVER['PHP_SELF']
	?>" class="btn" alt="START NEW GAME">START NEW GAME</a>
</div>

<div class="scoreTable">
	<div class="FirstPlayer"><? echo (intval($_GET['firstPlayerWins'])) ?></div>
	<div class="SecondPlayer"><? echo (intval($_GET['secondPlayerWins'])) ?></div>
</div>
<!--<script>
  document.getElementById('debugFrame').onclick = function() {
    document.getElementById('debugFrame').style.display = 'none';
  }
</script>-->
</body>
</html>