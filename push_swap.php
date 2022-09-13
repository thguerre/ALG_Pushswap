#!/usr/bin/php
<?php

class Sorter {

	private $la, $lb, $listLength, $position, $operations;

	public function __construct($argv)
	{
		$sTime = microtime(true)*1000;
		$this->parseList($argv);

		$this->listLength = count($this->la);
		$this->position = 0;
		$this->operations = 0;
		$this->operationsByLine = 31;
		$this->sort4();
		$this->lb = [];

		// for ($i=0;$i<6;$i++)
		// 	var_dump($this->getPosValue($i));

		$last = -1000000000000000000000000;
		
		echo "\nChecking sort validity...";
		for ($i = 0; $i < $this->listLength; $i++) {
			if ($this->la[$i] < $last)
				exit("tf not able to sort\n" . $this->la[$i] . PHP_EOL . $last . PHP_EOL);
			$last = $this->la[$i];
		}
		echo " PASSED";


		echo "\n\nDone sorting " . $this->listLength . " entries in " . $this->operations . " operations(".strval(round((microtime(true)*1000)-$sTime, 2))."ms)\n";
	}

	private function parseList(array $argv) : void
	{
		$this->la = array_slice($argv, 1);

		foreach ($this->la as $key => $value) {
			$this->la[$key] = intval($value);
		}

		$this->lb = [];
	}

	private function sort4() : void
	{
		//return;
		$turns = 0;
		$sorted = false;
		$lowStored = 0;
		while (true) {
			//echo "tru";
			// error exit condition
			if ($turns > $this->listLength) {
				throw new Error("Shouldn't happen");
				break;
			}

			// clean exit condition
			if (count($this->la) == 0) {
				echo "\n";
				$this->rrb();

				for ($i=0; $i<$lowStored; $i++)
					$this->rrb();

				while(count($this->lb) > 0) {
					$this->pa();
					$this->rrb();
				}
				break;
			}


			$highest = null;
			$highestIndex = 0;
			$lowest = null;
			$lowestIndex = 0;

			for ($i = 0; $i < count($this->la); $i++) {
				if (is_null($highest) || $this->la[$i] > $highest) {
					$highest = $this->la[$i];
					$highestIndex = $i;
				}
				if (is_null($lowest) || $this->la[$i] < $lowest) {
					$lowest = $this->la[$i];
					$lowestIndex = $i;
				}
			}

			// for highest
			$highDistanceUp = $highestIndex;
			$highDistanceDown = count($this->la)-$highestIndex;

			$highDirection = $highDistanceUp < $highDistanceDown ? 1 : -1;
			$highDistance = $highDistanceUp < $highDistanceDown ? $highDistanceUp : $highDistanceDown;

			$direction = $highDirection;
			$distance = $highDistance;
			$target = "highest";

			// for lowest
			if (!is_null($lowest) && $lowestIndex != $highestIndex) {
				$lowDistanceUp = $lowestIndex;
				$lowDistanceDown = count($this->la)-$lowestIndex;

				$lowDirection = $lowDistanceUp < $lowDistanceDown ? 1 : -1;
				$lowDistance = $lowDistanceUp < $lowDistanceDown ? $lowDistanceUp : $lowDistanceDown;

				if ($lowDistance < $highDistance) {
					$direction = $lowDirection;
					$distance = $lowDistance;
					$target = "lowest";
				}
			}

			for ($i = 0; $i < $distance; $i++) {
				if ($direction == 1)
					$this->ra();
				else
					$this->rra();
			}


			$this->pb();
			if ($target == "lowest") {
				$lowStored++;
				$this->rb();
			}


			$turns++;
		}
		echo "\n\nSort result: " . implode(" | ", $this->la) . PHP_EOL;
	}

	private function getFirstError() : int | null
	{
		for ($i = 0; $i < $this->listLength-1; $i++) {
			//var_dump($this->la[$i], $this->la[$i+1]);
			$isSorted = ($this->la[$i] <= $this->la[$i+1]);
			// var_dump($isSorted);
			if (!$isSorted)
				return $i;
		}
		return null;
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
		if (count($arr) < 1)
			return;
		$tmp = $arr[0];
		$arr[0] = $arr[1];
		$arr[1] = $tmp;
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
		// echo "==============================\n";
		// print_r($this->la);
		// print_r($this->lb);
		$transfered = array_shift($source);
		array_unshift($target, $transfered);
		// print_r($this->la);
		// print_r($this->lb);
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