<div class="card">
	<div class="front" style="background-image: url(<?=$foregroundImage;?>)">
	</div>
	<div class="back <?= $_SESSION['memoryMatch']['cardStates'][$cardIndex] ? 'hiddenCard' : '' ;?>">
		<a href="?cardIndex=<?=$cardIndex;?>"></a>
	</div>
</div>