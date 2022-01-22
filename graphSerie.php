<?php
require_once ('jpgraph/jpgraph.php');
require_once ('jpgraph/jpgraph_bar.php');

require_once ('include/functions.inc.php');

$array = getMostViewFilm(1);

for($i = 0; $i < count($array); $i++){
	$datay[$i] = $array[$i]["2"];
}

// Create the graph. These two calls are always required
$graph = new Graph(800,300);
$graph->clearTheme();
$graph->SetScale("textlin");

// Create a bar pot
$bplot = new BarPlot($datay);
$graph->Add($bplot);

// Setup the titles
//$graph->title->Set("Film les plus consultes");
$graph->xaxis->title->Set("Titre de la serie");
$graph->yaxis->title->Set("Nombre de consultations");

$maxLength = 12;

for($i = 0; $i < count($array); $i++){
	if(strlen($array[$i]["1"]) > $maxLength){
		$array[$i]["1"] = substr($array[$i]["1"], 0, $maxLength)."...";
	}
	else{
		$array[$i]["1"] = substr($array[$i]["1"], 0, $maxLength);
	}
}

for($i = 0; $i < count($array); $i++){
	$tickLabel[$i] = $array[$i]["1"];
}

$graph->xaxis->SetTickLabels($tickLabel);

// Display the graph
$graph->Stroke();
?>
