#!/usr/bin/php
<?php

class Sorter {

	private $la, $lb, $listLength, $position, $operations;

	public function __construct($argv)
	{
		$this->parseList($argv);

		$this->listLength = count($this->la);
		$this->position = 0;
		$this->operations = 0;
		$this->operationsByLine = 16;
		$this->sort();
		$this->lb = [];


		echo "\n";
	}

	private function parseList(array $argv) : void
	{
		$this->la = array_slice($argv, 1);

		foreach ($this->la as $key => $value) {
			$this->la[$key] = intval($value);
		}

		$this->lb = [];
	}

	private function sort() : void
	{
		//return;
		$sorted = false;
		while (!$sorted) {
			//
			break;
			$checkSorted;
		}
		//
	}

	private function checkSorted() : bool | int
	{
		if (count($this->lb) > 0)
			exit("lb not empty\n");
		$highest = $la[0];

		for ($i = 1; $i < $this->listLength; $i++) {
			break;
			//
		}
	}

	private function getPosValue(int $pos) : int
	{
		$countA = count($this->la);
		$countB = count($this->lb);
		$inListB = $pos < $countB;

		if ($inListB)
			return $this->lb[$countB - ($pos+1)];
		return $this->la[$pos - $countB];
	}

	private function printOperation(string $operation) : void
	{
		$firstOfLine = $this->operations % $this->operationsByLine == 0;
		echo ($firstOfLine ? "\n" : "")
			. (!$firstOfLine ? " " : "")
			. $operation;
		$this->operations++;
	}

	/**             MEMO
	 * array_splice($arr, $offset, $length) - remove part of an array
	 * array_unshift($arr, $val) - prepend value to array
	 */

	private function sa() : void
	{
		$this->printOperation("sa");
		$this->sref($this->la);
	}

	private function sb() : void
	{
		$this->printOperation("sb");
		$this->sref($this->lb);
	}

	private function sc() : void
	{
		$this->printOperation("sc");
		$this->sref($this->la);
		$this->sref($this->lb);
	}

	private function sref(array &$arr) : void
	{
		if (count($arr) > 1) {
			$tmp = $arr[0];
			$arr[0] = $arr[1];
			$arr[1] = $tmp;
		} else {
			echo "weird";
		}
	}

	private function pa() : void
	{
		$this->printOperation("pa");
		$this->pref($this->lb, $this->la);
	}

	private function pb() : void
	{
		$this->printOperation("pb");
		$this->pref($this->la, $this->lb);
	}

	private function pref(array &$source, array &$target) : void
	{
		if (count($source) == 0)
			return;
		echo "==============================\n";
		print_r($this->la);
		print_r($this->lb);
		$transfered = array_shift($source);
		array_unshift($target, $transfered);
		print_r($this->la);
		print_r($this->lb);
	}

	private function ra() : void
	{
		$this->printOperation("ra");
		$this->rref($this->la);
	}

	private function rb() : void
	{
		$this->printOperation("rb");
		$this->rref($this->lb);
	}

	private function rr() : void
	{
		$this->printOperation("rr");
		$this->rref($this->la);
		$this->rref($this->lb);
	}

	private function rref(array &$arr) : void
	{
		if (count($arr) < 2)
			return;
		$val = array_shift($arr);
		array_push($arr, $val);
	}

	private function rra() : void
	{
		$this->printOperation("rra");
		$this->rrref($this->la);
	}

	private function rrb() : void
	{
		$this->printOperation("rrb");
		$this->rrref($this->lb);
	}

	private function rrr() : void
	{
		$this->printOperation("rrr");
		$this->rrref($this->la);
		$this->rrref($this->lb);
	}

	private function rrref(array &$arr) : void
	{
		if (count($arr) < 2)
			return;
		$val = array_pop($arr);
		array_unshift($arr, $val);
	}
}

$sorter = new Sorter($argv);