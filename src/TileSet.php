<?php
namespace Domino;

/**
 * Class TileSet
 */
class TileSet{

	const POSITION_NONE = 0;

	const POSITION_HEAD = 1;

	const POSITION_TAIL = 2;

	private $tiles;

	/**
	 * Add tiles to positions
	 *
	 * @param
	 *        	$position
	 * @param
	 *        	$tile
	 * @throws \Exception
	 */
	public function add($position, $tile){
		switch($position){
			case self :: POSITION_HEAD:
				$this -> prepend($tile);
				break;
			case self :: POSITION_TAIL:
				$this -> append($tile);
				break;
			default:
				throw new \Exception("Adding $tile in an unknown position");
		}
	}

	/**
	 * Constructor
	 *
	 * @param array $tiles
	 */
	public function __construct(array $tiles = []){
		$this -> tiles = $tiles;
	}

	/**
	 * Prepender
	 *
	 * @param Tile $tile
	 * @return TileSet
	 */
	public function prepend(Tile $tile){
		array_unshift($this -> tiles, $tile);
		return $this;
	}

	/**
	 * Appender
	 *
	 * @param Tile $tile
	 * @return TileSet
	 */
	public function append(Tile $tile){
		$this -> tiles[] = $tile;
		return $this;
	}

	/**
	 * Get tile randomicly
	 *
	 * @return Tile
	 */
	public function getRandomTile(): Tile{
		$result = $this -> getRandomTiles(1);
		return $result[0];
	}

	/**
	 * Get tiles randomicly
	 *
	 * @param
	 *        	$amount
	 * @return array
	 */
	public function getRandomTiles($amount): array{
		$result = [];
		$keys = array_rand($this -> tiles, $amount);
		if($amount == 1){
			$keys = [
				$keys
			];
		}
		foreach($keys as $key){
			$result[] = $this -> tiles[$key];
			unset($this -> tiles[$key]);
		}
		return $result;
	}

	public function isEmpty(){
		return empty($this -> tiles);
	}

	public function head(){
		return $this -> tiles[0] -> head();
	}

	public function tail(){
		return $this -> tiles[count($this -> tiles) - 1] -> tail();
	}

	public function remove($key){
		if(isset($this -> tiles[$key])){
			unset($this -> tiles[$key]);
		}
	}

	public function all(){
		return $this -> tiles;
	}

	/**
	 *
	 * @inheritdoc
	 */
	public function __toString(){
		return implode(' ', $this -> tiles);
	}
}
