<?php
session_start();
require('memoryMatchConfig.php');
$refreshPageRequested = false;

if(!empty($_SESSION[MM_SESSION_KEY]['indicesToRevert'])){
	// print("<br>BEFORE CHANGE");
	// print_r($_SESSION[MM_SESSION_KEY]['cardStates']);
	forEach($_SESSION[MM_SESSION_KEY]['indicesToRevert'] as $indexToRevert){
		$_SESSION[MM_SESSION_KEY]['cardStates'][$indexToRevert] = false;
	}
	// print("<br>AFTER CHANGE");
	// print_r($_SESSION[MM_SESSION_KEY]['cardStates']);
	$_SESSION[MM_SESSION_KEY]['indicesToRevert'] = [];
	header("Location: {$_SERVER['PHP_SELF']}");
} else if(isset($_GET['cardIndex'])){
	$index = $_GET['cardIndex'];
	if(!$_SESSION[MM_SESSION_KEY]['cardStates'][$index]){
		$_SESSION[MM_SESSION_KEY]['cardStates'][$index] = true;
	}

	$_SESSION[MM_SESSION_KEY]['clickedCards'][] = $index;
	if(count($_SESSION[MM_SESSION_KEY]['clickedCards'])===2){
		$refreshPageRequested = !checkAndHandleCardMatch($_SESSION[MM_SESSION_KEY]['clickedCards'],$_SESSION[MM_SESSION_KEY]['cardStates'], $_SESSION[MM_SESSION_KEY]['cardData'] );
	}
}

if(!empty($_GET['reset'])){
	unset($_SESSION[MM_SESSION_KEY]);
	header('location: index.php');
}

if(empty($_SESSION[MM_SESSION_KEY])){
	$_SESSION[MM_SESSION_KEY] = [];
}

function checkAndHandleCardMatch(&$clickedCardsIndices, &$stateArray, $imageArray){
	$match = false;
	if($imageArray[$clickedCardsIndices[0]] === $imageArray[$clickedCardsIndices[1]]){
		$match = true;
	} else {
		$_SESSION[MM_SESSION_KEY]['indicesToRevert']= [$clickedCardsIndices[0], $clickedCardsIndices[1]];
		return false;
		// $stateArray[$clickedCardsIndices[0]] = false;
		// $stateArray[$clickedCardsIndices[1]] = false;
	}
	$clickedCardsIndices = [];
	$_SESSION[MM_SESSION_KEY]['matchCount']++;

	if(IMAGECOUNT ===$_SESSION[MM_SESSION_KEY]['matchCount']){
		$content = "
			<h3>You win!</h3>
			<a href='?reset=true'>Play again</a>
		";
		include('modal.php');
	}
	return $match;
}



if(empty($_SESSION[MM_SESSION_KEY]['cardData'])){
	$_SESSION[MM_SESSION_KEY]['cardData'] = createImageArray('images/foreground/*');
	$_SESSION[MM_SESSION_KEY]['cardStates'] = array_pad([], CARDCOUNT, false);
	$_SESSION[MM_SESSION_KEY]['clickedCards'] = [];
	$_SESSION[MM_SESSION_KEY]['matchCount'] = 0;
	$_SESSION[MM_SESSION_KEY]['indicesToRevert'] = [];
}


?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<?php
		if($refreshPageRequested){
			?>
				<meta http-equiv="refresh" content="<?=MISMATCH_REFRESH_TIME;?>">
			<?php
		}
	?>
</head>
<body>
	<div id="gameArea">
		<?php
		forEach($_SESSION[MM_SESSION_KEY]['cardData'] as $cardIndex => $foregroundImage){
			include('templates/card.php');
		}
		?>		
	</div>
</body>
</html>








