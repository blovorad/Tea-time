<?php 
	$titre = "Tea Time - statistique";
	$description = "Statistique du site Tea Time";
	include_once 'include/header.inc.php';
	include_once 'include/util.inc.php';
?>

<h1>Statistique du site</h1>

<section>
	<form id="search" method="post">
		<select name='typeStatistique'>
			<?php
			if(isset($_POST['typeStatistique'])){
				if($_POST['typeStatistique'] == 1){
					echo "<option value=\"0\">Film</option>\n";
					echo "\t\t\t<option selected=\"selected\" value=\"1\">Serie</option>\n";
					echo "\t\t\t<option value=\"2\">Film et Serie</option>";
				}
				else if($_POST['typeStatistique'] == 2){
					echo "<option value=\"0\">Film</option>\n";
					echo "\t\t\t<option value=\"1\">Serie</option>\n";
					echo "\t\t\t<option selected=\"selected\" value=\"2\">Film et Serie</option>";
				}
				else{
					echo "<option selected=\"selected\" value=\"0\">Film</option>\n";
					echo "\t\t\t<option value=\"1\">Serie</option>\n";
					echo "\t\t\t<option value=\"2\">Film et Serie</option>";
				}
			}
			else{
				echo "<option selected=\"selected\" value=\"0\">Film</option>\n";
				echo "\t\t\t<option value=\"1\">Serie</option>\n";
				echo "\t\t\t<option value=\"2\">Film et Serie</option>";
			}
			?>			
		</select>
		<input type="submit" value="Afficher les statistiques"/>
	</form>
	<?php
		if(isset($_POST['typeStatistique'])){
			if($_POST['typeStatistique'] == 0){
				echo "<h2>Statistique sur les films les plus vues</h2>\n";
				echo "\t<figure>\n";
				echo "\t\t<img src=\"./graphFilm.php\" alt=\"graph des films\"/>\n";
				echo "\t</figure>\n";
			}
			else if($_POST['typeStatistique'] == 1){
				echo "<h2>Statistique sur les series les plus vues</h2>\n";
				echo "\t<figure>\n";
				echo "\t\t<img src=\"./graphSerie.php\" alt=\"graph des series\"/>\n";
				echo "\t</figure>\n";
			}
			else{
				echo "<h2>Statistique sur les films et series les plus vues</h2>\n";
				echo "\t<figure>\n";
				echo "\t\t<img src=\"./graphFilmAndSerie.php\" alt=\"graph des series/films\"/>\n";
				echo "\t</figure>\n";
			}
		}
		else{
			echo "<h2>Statistique sur les films les plus vues</h2>\n";
			echo "\t<figure>\n";
			echo "\t\t<img src=\"./graphFilm.php\" alt=\"graph des films\"/>\n";
			echo "\t</figure>\n";
		} 
	?>
</section>

<section>
	<h2>Statistique des visiteurs</h2>
	<?php
		echo "<p class=\"text\">Nous avons enregistrés au total ".getVisitorNumber()." visites</p>\n";
		echo "\t<figure>\n";
		echo "\t\t<img src=\"./graphVisiteur.php\" alt=\"graph des visiteurs\"/>\n";
		echo "\t</figure>\n";
		getNumberVisitor();
	?>
</section>

<?php
	include_once 'include/footer.inc.php';
?>