<?php 
	$titre = "Tea Time - info film";
	$description = "Info du film que vous avez selectionner";
	include_once 'include/header.inc.php';
?>

<h1>Info du film</h1>
	
<section>
<?php
	include_once 'include/functions.inc.php';
	$arrayInfo = analyseSearch(hashUrl($_SERVER['REQUEST_URI']));
	manageStatistique($arrayInfo);
	setcookie("lastFilmSee", $arrayInfo["Id"], time()+60*60*24*30, "/");
	//print_r($arrayInfo);
	echo "\t<h2>".$arrayInfo["Title"]."</h2>\n";
	echo "\t<table class=\"infoFilm\">\n";
		echo "\t\t<tr>\n";
			echo "\t\t\t<td id=\"noBackgroundTd\">\n";
			if(strcmp($arrayInfo["Poster"], "N/A") == 0){
				echo "\t\t\t\t<img src=\"images/default.png\" alt=\"".$arrayInfo["Title"]."\"/>\n";
			}
			else{
				echo "\t\t\t\t<img src=\"".$arrayInfo["Poster"]."\" alt=\"".$arrayInfo["Title"]."\"/>\n";
			}
			echo "\t\t\t</td>\n";

			echo "\t\t\t<td class=\"backgroundTd\">\n";

			echo "\t\t\t<ul style=\"list-style: none\">\n";
			echo "\t\t\t\t<li lang=\"en\">Titre : ".$arrayInfo["Title"]."</li>\n";
			echo "\t\t\t\t<li>Année : ".$arrayInfo["Year"]."</li>\n";
			echo "\t\t\t\t<li>Réalisateur : ".$arrayInfo["Director"]."</li>\n";
			echo "\t\t\t\t<li lang=\"en\">Script  : ".$arrayInfo["Writer"]."</li>\n";
			echo "\t\t\t\t<li>Durée : ".$arrayInfo["Runtime"]."</li>\n";
			echo "\t\t\t\t<li lang=\"en\">Awards : ".$arrayInfo["Awards"]."</li>\n";
			echo "\t\t\t</ul>\n";

			echo "\t\t\t</td>\n";
		echo "\t\t</tr>\n";
	echo "\t</table>\n";

	echo "\t<p class=\"text\" lang=\"en\">\n";
	echo "\t\t".$arrayInfo["Plot"]."\n";
	echo "\t</p>\n";

	echo "\t<p class=\"text\">\n";
	echo "\t\tCe Film est disponible pour les langues suivante : ".$arrayInfo["Langage"].". Nous y retrouvons comme acteurs principaux : ".$arrayInfo["Actors"]."\n";
	echo "\t</p>\n";

	echo "\t<h2>Films du même genre</h2>\n";
	$arraySuggestion = getSameGenreFilm($arrayInfo["Title"], $arrayInfo["Type"], $arrayInfo["Id"]);
	echo "\t<table class=\"infoFilm\">\n";
		echo "\t\t<tr>\n";
			echo "\t\t\t<td class=\"backgroundTd\">\n";
			echo "\t\t\t<figure>\n";
			echo "\t\t\t\t<a href=\"infoFilm.php?i=".$arraySuggestion["Id1"]."\">\n";
			if(strcmp($arraySuggestion["Poster1"], "N/A") == 0){
				echo "\t\t\t\t<img src=\"images/default.png\" alt=\"".$arraySuggestion["Title1"]."\"/>\n";
			}
			else{
				echo "\t\t\t\t<img src=\"".$arraySuggestion["Poster1"]."\" alt=\"".$arraySuggestion["Title1"]."\"/>\n";
			}
			echo "\t\t\t\t</a>\n";
			echo "\t\t\t\t<figcaption>".$arraySuggestion["Title1"]."</figcaption>\n";
			echo "\t\t\t</figure>\n";
			echo "\t\t\t</td>\n";

			echo "\t\t\t<td class=\"backgroundTd\">\n";
			echo "\t\t\t<figure>\n";
			echo "\t\t\t\t<a href=\"infoFilm.php?i=".$arraySuggestion["Id2"]."\">\n";
			if(strcmp($arraySuggestion["Poster2"], "N/A") == 0){
				echo "\t\t\t\t<img src=\"images/default.png\" alt=\"".$arraySuggestion["Title2"]."\"/>\n";
			}
			else{
				echo "\t\t\t\t<img src=\"".$arraySuggestion["Poster2"]."\" alt=\"".$arraySuggestion["Title2"]."\"/>\n";
			}
			echo "\t\t\t\t</a>\n";
			echo "\t\t\t\t<figcaption>".$arraySuggestion["Title2"]."</figcaption>\n";
			echo "\t\t\t</figure>\n";
			echo "\t\t\t</td>\n";

			echo "\t\t\t<td class=\"backgroundTd\">\n";
			echo "\t\t\t<figure>\n";
			echo "\t\t\t\t<a href=\"infoFilm.php?i=".$arraySuggestion["Id3"]."\">\n";
			if(strcmp($arraySuggestion["Poster3"], "N/A") == 0){
				echo "\t\t\t\t<img src=\"images/default.png\" alt=\"".$arraySuggestion["Title3"]."\"/>\n";
			}
			else{
				echo "\t\t\t\t<img src=\"".$arraySuggestion["Poster3"]."\" alt=\"".$arraySuggestion["Title3"]."\"/>\n";
			}
			echo "\t\t\t\t</a>\n";
			echo "\t\t\t\t<figcaption>".$arraySuggestion["Title3"]."</figcaption>\n";
			echo "\t\t</figure>\n";
			echo "\t\t\t</td>\n";
		echo "\t\t</tr>\n";
	echo "\t</table>\n";
?>	
</section>

<?php
	include_once 'include/footer.inc.php';
?>