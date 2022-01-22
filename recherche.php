<?php 
    if(isset($_COOKIE["lastFilmSee"])){
        setcookie("lastFilmSee", $_COOKIE["lastFilmSee"], time()+60602430, "/");
    }
    else{
        setcookie("lastFilmSee", "", time()+60602430, "/");
    }
?>

<?php 
	$titre = "Tea Time - recherche";
	$description = "Recherche des films et series du site Tea Time";
	include_once 'include/header.inc.php';
	include_once 'include/functions.inc.php';
?>

<h1>Recherche d'un film ou d'une série </h1>

	<?php
		if(empty($_GET["title"]))
		{
			echo"<nav style=\"margin-top:17%\">";
			printf("");
			printf("<form id=\"search\" method=\"get\" action=\"recherche.php\">");
			printf( "\n\t<input name=\"title\" id=\"searchTextNul\" type=\"text\" placeholder=\"Saissisez votre recherche\"/>");
			echo( " <Button type=\"submit\" id=\"iconeFat\"> <img src=\"images/loupeBlanche.png\" alt=\"rechercher\"/> </Button>");
		}
		else
		{
			printf("<nav>");
			printf("<form id=\"search\" method=\"get\" action=\"recherche.php\">");
			printf( "\n\t<input name=\"title\" id=\"searchText\" type=\"text\" value=\"".$_GET["title"]."\"/>\n");
			echo( " <Button type=\"submit\" id=\"icone\"> <img src=\"images/loupeBlanche.png\" alt=\"rechercher\"/> </Button>");
		}
	?>
	
	<p> 
	    <?php
	        if(isset($_GET["Series"]) == true && isset($_GET["Films"]) == false){
	            echo "<input type=\"checkbox\" id=\"Films\" name=\"Films\" value=\"Film\" />";
	        }
	        else{
    		    echo "<input type=\"checkbox\" id=\"Films\" name=\"Films\" value=\"Film\" checked=\"checked\" />";
	        }
    	  	echo "<label for=\"Films\">Films</label>";
    	  	
    	  	if(isset($_GET["Series"]) == false){
        	  	echo "<input type=\"checkbox\" id=\"Series\" name=\"Series\" value=\"Serie\" />";
    	  	}
    	  	else{
    	  	    echo "<input type=\"checkbox\" id=\"Series\" name=\"Series\" value=\"Serie\" checked=\"checked\"/>";
    	  	}
      		echo "<label for=\"Series\">Séries</label>";
  	    ?>
	</p>
</form>
</nav> 
<?php
	// condition pour savoir si une recherche a déja été lancer pour changer l'affichage de la page
	if(empty($_GET["title"]) == false &&  (empty($_GET["Films"]) == false && (strcmp(htmlspecialchars($_GET["Films"]) , "Film" ) == 0)) || ( empty($_GET["Series"]) == false && strcmp(htmlspecialchars($_GET["Series"]) , "Serie" ) == 0))
	{
		printf("<section>");
		
		// préparation pour le titre pour la recherche
		$title = "s=" . htmlspecialchars($_GET["title"]) . "&series";
		$title =  str_replace ( " ", "%20" ,  $title);
			
		// affichage du titre plus lecture de la recherche selon le choix de l'utilisateur
		if(isset($_GET["Films"]) && isset($_GET["Series"]))
		{
			printf("\n\t<h2>Liste de Films et de séries</h2>");
			$movieList = search($title,"movie-series");
		}
		else if(isset($_GET["Films"]))
		{
			$movieList = search($title,"movie");
			printf("\n\t<h2>Liste de Films</h2>");
		}
		else
		{
			$movieList = search($title,"series");
			printf("\n\t<h2> Liste de séries</h2>");
		}
			
		// initialisation des index pour les tableau html
		$j = 0;
		$i = 0;
		$index = 0;
			
			
		// condition pour savoir si on a un résultat sur la recherche
		if(empty($movieList[$j]) == false)
		{
			printf("\n\t<table style=\" margin: auto\">");
			// boucle pour chaque nouvelle ligne du tableau
			while(empty($movieList[$j]) == false)
			{
				printf("\n\t\t<tr  id=\"".$index."\" style=\" text-align :center\">");
				
				// boucle pour chaque affichage de poster
				while( $i < 4 && empty($movieList[$j]) == false )
				{
					$movie = $movieList[$j];
					$id = $movie["Id"];
						
					printf("\n\t\t\t<td class=\"backgroundTd\" style=\"width:270px; height:350px\">");
					//echo "<figure>";
						
					$link = htmlspecialchars($_GET["title"]) . "&amp;id=" . $id . "&amp;type=". $movie["Type"];
					if(isset($_GET["Films"]))
					{
						$link = $link . "&amp;Films=Film";
					}
						
					if(isset($_GET["Series"]))
					{
						$link = $link . "&amp;Series=Serie";
					}
						
					// condition pour savoir si on à déja cliquer sur une image
					if(empty($_GET["id"]) == false && strcmp(htmlspecialchars($_GET["id"]), $id) == 0)
					{
						printf("\n\t<div style=\" margin-left: 0px; z-index: 3;display: block; width:170px; height:250px\">");
						echo"\n\t\t<ul style=\"list-style: none; z-index: 3; position: absolute\">";
									
						if(empty($_GET["id"]) == false)
						{
							$id = htmlspecialchars($_GET["id"]);
							$info = analyseSearchId($id);
							$res = explode(",", $info["Genre"]);
							$k = 0;
							$genre ="";
										
							// boucle pour mettre tout les genres sur une lignes différente
							while(empty($res[$k]) == false)
							{
								$genre = $genre . "<li style=\"text-align: left; margin-left: 10px\"> " . $res[$k] . "</li>\n\t\t";
								$k++;
							}
										
							// affichage des données sur le filme que nous avons cliquer
							printf("<li style=\"text-align: left\"> Genre: </li>");
							printf($genre);
							printf("\n\t\t\t<li style=\"text-align: left\"> Année: " . $info["Year"] . "</li>"); 
							printf("\n\t\t\t<li style=\"text-align: left\"> Durée: " . $info["Runtime"] . "</li>");
							printf("\n\t\t\t<li id=\"more\"> <a id=\"moreInfo\" href=\"infoFilm.php?i=" . $_GET["id"] . "&amp;type=" . $_GET["type"] . "\">voir plus </a> </li>");
							echo "</ul>";
						}
						
						// affichage du poster du filme							
						echo "<figure style=\"width:170px; height:250px \">";
						printf("<a style=\"z-index: 0\" href=\"recherche.php?title=" . $link ."#".$index. "\" > <img style=\"opacity:0.2; 
						width:170px; height:250px \" src=\"".$movie["Poster"]."\" alt=\"".$movie["Title"]."\"/> </a>");
						echo "<figcaption lang=\"en\">".$movie["Title"]."</figcaption>";
				   		echo "</figure>";
						printf("</div>");
							
					}
					// affichage des filmes sans information
					else
					{
						//affichage du poster des filmes avec leur titre comme légende
						echo "<figure style=\"width:170px; height:250px \">";
						printf("\n\t\t\t <a href=\"recherche.php?title=" . $link . "#".$index. "\" > \n\t\t\t <img style=\"width:170px; height:250px \"  
						src=\"".$movie["Poster"]."\" alt=\"".$movie["Title"]."\"/> \n\t\t\t </a>");
						echo "<figcaption lang=\"en\">".$movie["Title"]."</figcaption>";
				   		echo "</figure>";
					}
						
					printf("\n\t\t\t</td>\n");
					  	
					$j++;
					$i++;
				}
				//pour la validation xhtml garder un nombre de td cohérent et toujours le même
				if($i < 4){
					printf("\n\t\t\t<td id=\"noBackgroundTd\">");
					printf("\n\t\t\t</td>\n");
					$i++;
					for($dependance = $i; $dependance < 4; $dependance++){
						printf("\n\t\t\t<td>");
						printf("\n\t\t\t</td>\n");
					}
				}
				$index++;
				printf("\n\t\t</tr>");
				$i = 0;
				
			}
				
			printf("\n\t\t</table>");
		}
		// si pas de résultat après la recherche 
		else
		{
			print("\n<p class=\"text\"> Aucune correspondance a votre recherche. </p>");
			echo "<p style=\"margin-top: 20%\"></p>";
		}
			
		printf("\n</section>");
	}
	// affichage si l'utilisateur na pas fait de recherche
	else
	{
		// affichage du dernier film regarder si l'utilisateur a déja fait une recherche
		if(isset($_COOKIE["lastFilmSee"]))
		{    
			echo "\n\t<section style=\"	margin-right: 12%; margin-left: 20%;margin-top: 10%\">\n\t<h2 style=\"\">Dernier film vue</h2>\n";   
            // recherche du film du cookie
            $film = analyseSearch("i=".$_COOKIE["lastFilmSee"]);
                
            if(empty($_GET["id"]) == false)
			{
				printf("\t\t<table> \n\t\t\t<tr> \n\t\t\t<td class=\"backgroundTd\" style=\"width:400px; height:550px \">");
				printf("\n\t<div style=\" margin-left: 0px; z-index: 3;display: block; width:270px; height:450px\">");
				echo"\n\t\t<ul style=\" font-size: 25px;list-style: none; z-index: 3; position: absolute; margin-left: 25px\">";
									
				if(empty($_GET["id"]) == false)
				{
					$id = htmlspecialchars($_GET["id"]);
					$info = analyseSearchId($id);
					$res = explode(",", $info["Genre"]);
					$k = 0;
					$genre ="";
						
					// boucle pour mettre tout les genres sur une lignes différente				
					while(empty($res[$k]) == false)
					{
						$genre = $genre . "<li style=\"text-align: left; margin-left: 35px\"> " . $res[$k] . "</li>\n\t\t";
						$k++;
					}
						
					// affichage des données sur le filme que nous avons clicker			
					printf("<li style=\"text-align: left\"> Genre: </li>");
					printf($genre);
					printf("\n\t\t\t<li style=\"text-align: left\"> Année: " . $info["Year"] . "</li>"); 
					printf("\n\t\t\t<li style=\"text-align: left\"> Durée: " . $info["Runtime"] . "</li>");
					printf("\n\t\t\t<li id=\"more\"> <a id=\"moreInfo\" style=\"font-size: 40px\" href=\"infoFilm.php?i=" . $_GET["id"] . "&amp;type=" . $info["Type"] . "\">voir plus </a> </li>");
				}
													
				echo "</ul>";
				echo "<figure style=\"width:270px; height:450px \">";
				printf("<a style=\"z-index: 0\" href=\"recherche.php\" > 
				<img style=\"opacity:0.2; width:270px; height:450px \" src=\"".$film["Poster"]."\" alt=\"".$film["Title"]."\"/> </a>");
				echo "<figcaption>".$film["Title"]."</figcaption>";
				echo "</figure>";
				printf("</div>");
					
				printf("</td> </tr> </table>");
							
			}
			else
			{
				printf("\n\t\t<table> \n\t\t\t<tr> \n\t\t\t<td class=\"backgroundTd\" style=\"width:400px; height:550px \">");
				echo "\n\t\t\t<figure style=\"width:270px; height:450px \">\n";
				echo "\t\t\t<a href=\"recherche.php?id=".$film["Id"]."\">\n";
					
				// on regarde si le film à un poster ou non
				if(strcmp($film["Poster"], "N/A") == 0)
				{
					echo "\t\t\t<img style=\"width:270px; height:450px \" src=\"images/default.png\" alt=\"".$film["Title2"]."\"/>";
				}
				else
				{
					echo "\t\t\t<img style=\"width:270px; height:450px \" src=\"".$film["Poster"]."\" alt=\"".$film["Title"]."\"/>";
				}
					
				echo "\t\t</a>\n";
				echo "\t\t\t<figcaption lang=\"en\" id=\"captionIndex\">".$film["Title"]."</figcaption>\n";

				echo "\t\t\t</figure>\n";
				printf("\t\t\t</td> \n\t\t\t</tr> \n\t\t</table>");
			}
			
			printf("\n</section>");
		}
		
	}
?>

<?php
	include_once 'include/footer.inc.php';
?>
