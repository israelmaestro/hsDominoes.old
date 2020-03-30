<?php
namespace Domino;

/**
 * Class Game
 *
 * @package Domino
 */
class Game{

	private $finished = false;
	private $stock;
	private $board;
	private $players;
	
	/**
	 * Play the game
	 */
	public function play(){
		$this -> initialize();
		$this -> output("<p style='text-align: center; color: #900; font-weight: bold; text-transform: uppercase; background: #FEC; border: solid 2px #900;'>Game starting with first tile: <img src='img/{$this->board}.png'/></p>");

		while(!$this -> finished){
			foreach($this -> players as $player){
				try{
					$boardImages = "";
					$board = explode(" ", $this -> board);

					foreach($board as $t){
						$boardImages = $boardImages . " <img src='img/$t.png'/>";
					}

					$this -> output("<p style='background: #EEE; color: #666; border: solid 2px #666;'>Board is now: {$boardImages}</p>");
					$this -> turn($player);
					$this -> checkForWinner($player);
					$this -> checkForTilesInStock();

					if($this -> finished){
						break;
					}
				}catch(\Exception $exception){
					$this -> output($exception -> getMessage());
				}
			}
		}
	}

	/**
	 * Turn between Player 1 and Player 2
	 *
	 * @param Player $player
	 * @throws \Exception
	 */
	private function turn(Player $player){
		$tile = null;
		$position = TileSet :: POSITION_NONE;

		while(empty($tile) && !$this -> stock -> isEmpty()){

			list ($position, $tile) = $player -> move($this -> board -> head(), $this -> board -> tail());

			if(empty($tile)){

				$tileFromStock = $this -> stock -> getRandomTile();
				$player -> prependTile($tileFromStock);
				$this -> output("<p style='background: #FFC; border: solid 2px #990; color: #990;'>$player can't play! Drawing tile: <img src='img/$tileFromStock.png'/></p>");
			}
		}

		if(!empty($tile)){
			$this -> output("<p style='background: #CFC; border: solid 2px #090; color: #090;'>$player plays: <img src='img/$tile.png' style='vertical-align: middle; zoom: 0.5;'/></p>");
			$this -> board -> add($position, $tile);
		}
	}

	/**
	 * Init Game Parameters
	 */
	private function initialize(){
		$this -> stock = new TileSet();
		for($tail = 0; $tail <= 6; $tail++){
			for($head = 0; $head <= $tail; $head++){
				$tile = new Tile($head, $tail);
				$this -> stock -> append($tile);
			}
		}

		$this -> board = new TileSet();
		$this -> board -> append($this -> stock -> getRandomTile());

		$this -> players[] = new Player('Player 1', new TileSet($this -> stock -> getRandomTiles(7)));
		$this -> players[] = new Player('Player 2', new TileSet($this -> stock -> getRandomTiles(7)));
	}
	
	/**
	 * Check if there is a winner
	 *
	 * @param Player $player
	 */
	private function checkForWinner(Player $player){
		if($player -> isOutOfTiles()){
			$this -> output("<p style='text-align: center; background: #CEF; color: #00F; font-weight: bold; text-transform: uppercase; border: solid 2px #00F;'>$player is the winner!!</p>");
			$this -> finished = true;
		}
	}
	
	/**
	 * Check if there is tiles in stock
	 */
	private function checkForTilesInStock(){
		if($this -> stock -> isEmpty()){
			$this -> output("<p style='text-align: center; background: #CEF; color: #00F; font-weight: bold; text-transform: uppercase; border: solid 2px #00F;'>Tiles out of stock! Nobody wins!!</p>");
			$this -> finished = true;
		}
	}

	private function output($message){
		echo "$message\n\n";
	}
}
