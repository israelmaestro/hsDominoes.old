<?php
namespace Domino;

/**
 * Class Tile
 *
 * @package Domino
 */
class Tile{
	protected $head;
	protected $tail;

	/**
	 * Constructor
	 *
	 * @param $head
	 * @param $tail
	 */
	public function __construct($head, $tail){
		$this -> head = $head;
		$this -> tail = $tail;
	}

	/**
	 * Matcher
	 *
	 * @param $head
	 * @param $tail
	 * @return int
	 */
	public function matches($head, $tail){
		if($this -> tail() === $head || $this -> flip() -> tail() === $head){
			return TileSet :: POSITION_HEAD;
		}

		if($this -> head() === $tail || $this -> flip() -> head() === $tail){
			return TileSet :: POSITION_TAIL;
		}
		return TileSet :: POSITION_NONE;
	}

	public function head(){
		return $this -> head;
	}

	public function tail(){
		return $this -> tail;
	}

	/**
	 * Flip head and tail
	 *
	 * @return $this
	 */
	public function flip(){
		$tempHead = $this -> head;
		$this -> head = $this -> tail;
		$this -> tail = $tempHead;
		return $this;
	}

	public function __toString(){
		return "{$this->head}_{$this->tail}";
	}
}
