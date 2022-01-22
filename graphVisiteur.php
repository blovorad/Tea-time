<?php // content="text/plain; charset=utf-8"
require_once ('jpgraph/jpgraph.php');
require_once ('jpgraph/jpgraph_bar.php');
require_once ('./include/util.inc.php');

$array = getNumberVisitor();
$arrayLabel = array();
$arrayVisitor = array();

// Some data
for($i = 0; $i < count($array); $i++){
	$split = explode(":", $array[$i]);
	$arrayLabel[$i] = $split["0"];
	$arrayVisitor[$i] = $split["1"];
	$datay[$i] = intval($arrayVisitor[$i]);
}

// Create the graph. These two calls are always required
$graph = new Graph(800,300);
$graph->clearTheme();
$graph->SetScale('textlin');

// Create the linear plot
$bplot = new BarPlot($datay);
$graph->Add($bplot);


$graph->title->Set("Visiteurs au cours du temps");
$graph->xaxis->title->Set("Date Y-M-D");
$graph->yaxis->title->Set("Visiteurs");

for($i = 0; $i < count($arrayLabel); $i++){
	$labelBis = substr($arrayLabel[$i], 2);
	$tickLabel[$i] = $labelBis;
}

$graph->xaxis->SetTickLabels($tickLabel);

// Display the graph
$graph->Stroke();
?>
