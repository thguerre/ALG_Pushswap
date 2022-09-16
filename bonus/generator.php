#!/usr/bin/php
<?php

// choose files and dataset to be generated
$ranges = [5, 10, 50, 100, 500, 1000, 5000, 6000, 7500, 10000];

// start and naming format for each file, here all files32 will be sh files
$initiator  = "#!/usr/bin/sh\n./push_swap.php";
$directory  = "./testers";
$filePrefix = "test_";
$fileSuffix = ".sh";

// directory existence and creation check
$dirOK = true;
if (!file_exists($directory))
	$dirOK = mkdir($directory);

if (!is_dir($directory) || !$dirOK)
	exit("Error with directory creation\n");

// for each dataset, generate numbers and file
for ($i=0; $i < count($ranges); $i++) {
	$values = [$initiator];
	for ($j=0; $j < $ranges[$i]; $j++) {
		array_push($values, rand()*(rand(1,2)==1?-1:1));
	}
	$filename = $directory . "/" . $filePrefix . strval($ranges[$i]) . $fileSuffix;
	file_put_contents($filename, implode(" ", $values));
}
