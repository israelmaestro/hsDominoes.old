<style>
	*{
		font-family: sans-serif;
		font-size: 1.25em;
	}
	p{
		padding: 8px;
		border-radius: 8px;
	}
	img{
		vertical-align: middle;
		zoom: 0.5;
	}
	body{
		overflow: auto;
	}
</style>
<?php
include 'autoloader.php';

use Domino\Game;

$game = new Game();
$game -> play();
