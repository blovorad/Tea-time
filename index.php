<?php
	$titre = "Tea Time";
	$description = "Site repertoriant une multitude de site et serie";
	include_once 'include/header.inc.php';
	include_once 'include/util.inc.php';
	addVisitorStat();
?>

<h1>Tea Time</h1>

<section>

	<h2>Bienvenue <img style="margin-left: 27%" src="images/clap.png" alt="Clap ciné picture" width="100"/></h2>

	<p class="text">
		Bienvenue sur le site Tea Time. Ce site regroupe une grande liste de films et séries de tout horizon, qui à coup sûr plairont aux petits comme aux grands.
	</p>
	<p class="text">
		Pour rechercher un film ou une série vous pouvez allez dans la section <a href="recherche.php">rechercher</a> du site.
	</p>
	<p class="text">
		Vous pouvez à tout moment consulté les films et séries préféré des autres utilisateurs ainsi que les votres. Dans la section <a href="statistique.php">statistique du site</a>.
	</p>
</section>

<section>
	<?php 
		require_once 'include/functions.inc.php';
		$image = extractImageFromNasaApi();
		if(stristr($image, "youtube") == true){
			echo "<h2>Vidéo du jour</h2>\n";
			echo "\t<p class=\"text\">\n";
			echo "\t\tNous vous proposons pour le plaisir des yeux, la vidéo du jour prise par la NASA.\n";
			echo "\t</p>\n";
			echo "\t<figure>\n";
			echo "\t\t<iframe src=\"".$image."\" height=\"300\" width=\"400\"></iframe>\n";
			echo "\t</figure>\n";
		}
		else{
			echo "<h2>Image du jour</h2>\n";
			echo "\t<p class=\"text\">\n";
			echo "\t\tNous vous proposons pour le plaisir des yeux, la photo du jour prise par la NASA.\n";
			echo "\t</p>\n";
			echo "\t<figure>\n";
			echo "\t\t<img src=\"".$image."\" alt=\"NASA IMAGE\" height=\"300\" width=\"400\"/>\n";
			echo "\t</figure>\n";
		}
	?>

	<p class="text">
		Localisation : 
		<?php
			echo ExtractCityOfIpAdresse(getIpAdresseOfUser());
		?>
	</p>
</section>

<?php
	include_once 'include/footer.inc.php';
?>