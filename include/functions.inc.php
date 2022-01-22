<?php
        define("MAX_FILM_AND_SERIE_PRINT", "4");

        /*Cette fonction nous donne l'image/vidéo du jour de l'api de la nasa*/
        function extractImageFromNasaApi(): string{
            $fluxJson = fopen("https://api.nasa.gov/planetary/apod?api_key=4Az27ft1f0a67UFJT8BeMLXdndk8ksJvGDvfL1HL", "r");
            $img = fgets($fluxJson);

            $img = explode("url\":\"", $img);
            $img = str_replace("}", "", $img);
            $img = str_replace("\"", "", $img);
            $img = str_replace("\n", "", $img);

            fclose($fluxJson);
            if(stristr($img[1], "youtube") == true){
                return $img[1];
            }
            else{
                return $img[2];
            }
        }

        /*Cette fonction permet de ressortir sous forme d'un array les 5 films/séries les plus vu du site*/
        function getMostViewFilm(int $type): array{
            if($type == 0){
                $file = fopen("./fichier/statFilm.csv", "r");
                $mostViewFilm = array();
                $filmCount = 0;
                $goOut = 0;

                $mostViewFilm[$filmCount] = fgetcsv($file, 200, ";");
                while($mostViewFilm[$filmCount] != false && $goOut == 0){
                    $filmToCompare = fgetcsv($file, 200, ";");
                    if($filmCount >= MAX_FILM_AND_SERIE_PRINT){
                        if($filmToCompare == false){
                            $goOut = 1;
                        }
                        else{
                            $lessView = $mostViewFilm["0"];
                            $idToChange = 0;
                            for($i = 1; $i < MAX_FILM_AND_SERIE_PRINT + 1; $i++){
                                if($lessView["2"] > $mostViewFilm[$i]["2"]){
                                    $lessView = $mostViewFilm[$i];
                                    $idToChange = $i;
                                } 
                            }
                            if($lessView["2"] < $filmToCompare["2"]){
                                $mostViewFilm["".$idToChange] = $filmToCompare;
                            }
                        }
                    }
                    else{
                        if(isset($filmToCompare["1"])){
                            $filmCount += 1;
                            $mostViewFilm[$filmCount] = $filmToCompare;
                        }
                        else{
                            $goOut = 1;
                        }
                    }
                }
                fclose($file);
                return $mostViewFilm;
            }
            else if($type == 1){
                $file = fopen("./fichier/statSerie.csv", "r");
                $serieCount = 0;
                $goOut = 0;

                $mostViewSerie[$serieCount] = fgetcsv($file, 200, ";");
                while($mostViewSerie[$serieCount] != false && $goOut == 0){
                    $serieToCompare = fgetcsv($file, 200, ";");
                    if($serieCount >= MAX_FILM_AND_SERIE_PRINT){
                        if($serieToCompare == false){
                            $goOut = 1;
                        }
                        else{
                            $lessView = $mostViewSerie["0"];
                            $idToChange = 0;
                            for($i = 1; $i < MAX_FILM_AND_SERIE_PRINT + 1; $i++){
                                if($lessView["2"] > $mostViewSerie[$i]["2"]){
                                    $lessView = $mostViewSerie[$i];
                                    $idToChange = $i;
                                } 
                            }
                            if($lessView["2"] < $serieToCompare["2"]){
                                $mostViewSerie["".$idToChange] = $serieToCompare;
                            }
                        }
                    }
                    else{
                        if(isset($serieToCompare["1"])){
                            $serieCount += 1;
                            $mostViewSerie[$serieCount] = $serieToCompare;
                        }
                        else{
                            $goOut = 1;
                        }
                    }
                }
                fclose($file);
                return $mostViewSerie;
            }
            else{
                $file = fopen("./fichier/statFilm.csv", "r");
                $filmAndSerieMostView = array();
                $filmCount = 0;
                $goOut = 0;

                $filmAndSerieMostView[$filmCount] = fgetcsv($file, 200, ";");
                while($filmAndSerieMostView[$filmCount] != false && $goOut == 0){
                    $filmToCompare = fgetcsv($file, 200, ";");
                    if($filmCount >= MAX_FILM_AND_SERIE_PRINT){
                        if($filmToCompare == false){
                            $goOut = 1;
                        }
                        else{
                            $lessView = $filmAndSerieMostView["0"];
                            $idToChange = 0;
                            for($i = 1; $i < MAX_FILM_AND_SERIE_PRINT + 1; $i++){
                                if($lessView["2"] > $filmAndSerieMostView[$i]["2"]){
                                    $lessView = $filmAndSerieMostView[$i];
                                    $idToChange = $i;
                                } 
                            }
                            if($lessView["2"] < $filmToCompare["2"]){
                                $filmAndSerieMostView["".$idToChange] = $filmToCompare;
                            }
                        }
                    }
                    else{
                        if(isset($filmToCompare["1"])){
                            $filmCount += 1;
                            $filmAndSerieMostView[$filmCount] = $filmToCompare;
                        }
                        else{
                            $goOut = 1;
                        }
                    }
                }

                fclose($file);

                $file = fopen("./fichier/statSerie.csv", "r");
                $serieCount = $filmCount + 1;
                $starterCount = $serieCount;
                $goOut = 0;

                $filmAndSerieMostView[$serieCount] = fgetcsv($file, 200, ";");
                while($filmAndSerieMostView[$serieCount] != false && $goOut == 0){
                    $serieToCompare = fgetcsv($file, 200, ";");
                    if($serieCount >= $filmCount + MAX_FILM_AND_SERIE_PRINT){
                        if($serieToCompare == false){
                            $goOut = 1;
                        }
                        else{
                            $lessView = $filmAndSerieMostView["".$starterCount];
                            $idToChange = $starterCount;
                            for($i = ($starterCount + 1); $i < (MAX_FILM_AND_SERIE_PRINT + $filmCount) + 1; $i++){
                                if($lessView["2"] > $filmAndSerieMostView[$i]["2"]){
                                    $lessView = $filmAndSerieMostView[$i];
                                    $idToChange = $i;
                                } 
                            }
                            if($lessView["2"] < $serieToCompare["2"]){
                                $filmAndSerieMostView["".$idToChange] = $serieToCompare;
                            }
                        }
                    }
                    else{
                        if(isset($serieToCompare["1"])){
                            $serieCount += 1;
                            $filmAndSerieMostView[$serieCount] = $serieToCompare;
                        }
                        else{
                            $goOut = 1;
                        }
                    }
                }
                fclose($file);
                return $filmAndSerieMostView;
            }

        }

        /*Cette fonction permet d'ajouter le film/série consulter dans un fichier qui correspond à son type et si il existe d'augmenter le nombre visite sur le film./série*/
        function manageStatistique(array $array): void{
            $path;

            if($array["Type"] == "movie"){
                $path = "./fichier/statFilm.csv";
            }
            else{
                $path = "./fichier/statSerie.csv";
            }
            $file = fopen($path, "r");
            $infoStat = array("Id" => "".$array["Id"], "Title" => "".$array["Title"], "Vue" => "1");
            $movieInFile = array();
            $size = 0;
            $alreadyInFile = 0;

            $movieInFile[$size] = fgetcsv($file, 200, ";");
            while($movieInFile[$size] != false && $alreadyInFile == 0){
                if(strcmp($movieInFile[$size]["0"], $infoStat["Id"]) == 0){
                    $movieInFile[$size]["2"] += 1;
                    $alreadyInFile = 1;
                }
                if(isset($movieInFile[$size]["1"])){
                    $size += 1;
                }
                $movieInFile[$size] = fgetcsv($file, 200, ";");
            }

            if($alreadyInFile == 0){
                $movieInFile[$size] = $infoStat;
                $size += 1;
            }
            fclose($file);

            $file = fopen($path, "w");

            for($i = 0; $i < $size; $i++){
                fputcsv($file, $movieInFile[$i], ";");
            }

            fclose($file);
        }

        /*Cette fonction permet d'extraire la ville ou se situe l'adresse ip*/
        function ExtractCityOfIpAdresse(string $ip): string{
            $fluxXml = fopen("http://www.geoplugin.net/xml.gp?ip=".$ip, "r");
            $found = 1;
            
            while($found == 1 && ($lineOfFluxXml = fgets($fluxXml)) !== false){
                if(strpos($lineOfFluxXml, "geoplugin_city") !== false){
                    $lineOfFluxXml = str_replace("<geoplugin_city>", "", $lineOfFluxXml);
                    $lineOfFluxXml = str_replace("</geoplugin_city>", "", $lineOfFluxXml);
                    $found = 0;
                }
            }

            fclose($fluxXml);
            
            return $lineOfFluxXml;
         }

        /*Cette fonction permet de récupérer l'adresse ip de l'utilisateur*/
        function getIpAdresseOfUser(): string{
            if(!empty($_SERVER['HTTP_CLIENT_IP'])){
              $ip = $_SERVER['HTTP_CLIENT_IP'];
            }
            else if(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
              $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            }
            else{
              $ip = $_SERVER['REMOTE_ADDR'];
            }
            return $ip;
        }
        
        /*Cette fonction permet d'utiliser l'api et de rendre le lien sous forme d'array*/
        function analyseSearch(string $search): array{
            $flux = fopen("http://www.omdbapi.com/?apikey=aef12ffe&".$search, "r");
            $array = array("Title" => "", "Year" => "", "Rated" => "", "Released" => "", "Runtime" => "", "Genre" => "", "Director" => "", "Writer" => "", "Actors" => "", "Plot" => "", 
                            "Langage" => "", "Country" => "", "Awards" => "", "Poster" => "", "Id" => "", "Type" => "");

            $resultPoster = fgets($flux);

            $result = explode("\",\"", $resultPoster);

            $title = explode("{\"Title\":\"", $result[0]);
            $array["Title"] = $title[1];

            $year = explode("Year\":\"", $result[1]);
            $array["Year"] = $year[1];

            $rated = explode("Rated\":\"", $result[2]);
            $array["Rated"] = $rated[1];

            $released = explode("Released\":\"", $result[3]);
            $array["Released"] = $released[1];

            $runtime = explode("Runtime\":\"", $result[4]);
            $array["Runtime"] = $runtime[1];

            $genre = explode("Genre\":\"", $result[5]);
            $array["Genre"] = $genre[1];

            $director = explode("Director\":\"", $result[6]);
            $array["Director"] = $director[1];

            $writer = explode("Writer\":\"", $result[7]);
            $array["Writer"] = $writer[1];

            $actor = explode("Actors\":\"", $result[8]);
            $array["Actors"] = $actor[1];

            $plot = explode("Plot\":\"", $result[9]);
            $array["Plot"] = $plot[1];

            $langage = explode("Language\":\"", $result[10]);
            $array["Langage"] = $langage[1];

            $country = explode("Country\":\"", $result[11]);
            $array["Country"] = $country[1];

            $awards = explode("Awards\":\"", $result[12]);
            $awards[1] = str_replace("&", "&amp;", $awards[1]);
            $array["Awards"] = $awards[1];

            $poster = explode("Poster\":\"",$result[13]);
            $array["Poster"] = $poster[1];

            $posId = strpos($resultPoster, "imdbID\":\"") + 9;
            $endPosId = strpos($resultPoster, "\",\"Type");

            $id = substr($resultPoster, $posId, $endPosId - $posId);
            $array["Id"] = $id;

            $posType = strpos($resultPoster, "Type\":\"") + 7;
            $endPosType = strpos($resultPoster, "\",\"DVD");

            $type = substr($resultPoster, $posType, $endPosType - $posType);
            $array["Type"] = $type;

            fclose($flux);
            return $array;
        }
        
        function analyseSearchId(string $search): array{
            $flux = fopen("http://www.omdbapi.com/?apikey=aef12ffe&i=".$search, "r");
            $array = array("Title" => "", "Year" => "", "Rated" => "", "Released" => "", "Runtime" => "", "Genre" => "", "Director" => "", "Writer" => "", "Actors" => "", "Plot" => "", 
                            "Langage" => "", "Country" => "", "Awards" => "", "Poster" => "", "Id" => "", "Type" => "");

            $resultPoster = fgets($flux);

            $result = explode("\",\"", $resultPoster);

            $title = explode("{\"Title\":\"", $result[0]);
            $array["Title"] = $title[1];

            $year = explode("Year\":\"", $result[1]);
            $array["Year"] = $year[1];

            $rated = explode("Rated\":\"", $result[2]);
            $array["Rated"] = $rated[1];

            $released = explode("Released\":\"", $result[3]);
            $array["Released"] = $released[1];

            $runtime = explode("Runtime\":\"", $result[4]);
            $array["Runtime"] = $runtime[1];

            $genre = explode("Genre\":\"", $result[5]);
            $array["Genre"] = $genre[1];

            $director = explode("Director\":\"", $result[6]);
            $array["Director"] = $director[1];

            $writer = explode("Writer\":\"", $result[7]);
            $array["Writer"] = $writer[1];

            $actor = explode("Actors\":\"", $result[8]);
            $array["Actors"] = $actor[1];

            $plot = explode("Plot\":\"", $result[9]);
            $array["Plot"] = $plot[1];

            $langage = explode("Language\":\"", $result[10]);
            $array["Langage"] = $langage[1];

            $country = explode("Country\":\"", $result[11]);
            $array["Country"] = $country[1];

            $awards = explode("Awards\":\"", $result[12]);
            $array["Awards"] = $awards[1];

            $poster = explode("Poster\":\"",$result[13]);
            $array["Poster"] = $poster[1];

            $posId = strpos($resultPoster, "imdbID\":\"") + 9;
            $endPosId = strpos($resultPoster, "\",\"Type");

            $id = substr($resultPoster, $posId, $endPosId - $posId);
            $array["Id"] = $id;

            $posType = strpos($resultPoster, "Type\":\"") + 7;
            $endPosType = strpos($resultPoster, "\",\"DVD");

            $type = substr($resultPoster, $posType, $endPosType - $posType);
            $array["Type"] = $type;

            fclose($flux);
            return $array;
        }
        
        function search(string $search, string $selectType): array{
            $flux = fopen("http://www.omdbapi.com/?apikey=aef12ffe&".$search . "&page=1-100", "r");
            $array = array("Title" => "", "Year" => "", "Rated" => "", "Realised" => "", "Runtime" => "", "Genre" => "", "Director" => "", "Writer" => "", "Actors" => "", "Plot" => "", 
                            "Langage" => "", "Country" => "", "Awards" => "", "Poster" => "", "None"=>"no");
                            
            $result = fgets($flux);
            $movies = array();
            
            if(strcmp($result,"{\"Response\":\"False\",\"Error\":\"Movie not found!\"}") == 0)
            {
                return $array;
            }
             
            $result = explode("{", $result);
            $i = 2;
            $j = 0;
            
            while(empty($result[$i]) == false)
            {
                
                $info = str_replace("{\"Search\":[","", $result[$i]);
                $info = explode("\",\"", $result[$i]);

                $title = explode("\":\"", $info[0]);
                $array["Title"] = $title[1];

                $Year = explode("\":\"", $info[1]);
                $array["Year"] = $Year[1];
                
                $id = explode("\":\"", $info[2]);
                $array["Id"] = $id[1];
                
                $Type = explode("\":\"", $info[3]);
                $array["Type"] = $Type[1];

                $poster = explode("\":\"", $info[4]);
                $poster1 = $poster[1];
                $poster = explode("}", $poster1);
                $poster1 = str_replace("\"","",$poster[0]);
               
                if( strcmp($poster1, "N/A") == 0)
                {
                    $poster1 = "images/default.png";
                }
                     $array["Poster"] = $poster1;
                
                if($array["Type"] != "game")
                {
                    if(strcmp($selectType , "series") == 0)
                    {
                        if(strcmp($array["Type"], "series") == 0)
                        {
                            $movies[$j] = $array;
                            $j++;
                        }
                    }
                    else if(strcmp($selectType , "movie") == 0)
                    {
                        if(strcmp($array["Type"], "movie") == 0)
                        {
                            $movies[$j] = $array;
                            $j++;
                        }
                    }
                    else if(strcmp($selectType ,"movie-series") == 0)
                    {
                        $movies[$j] = $array;
                        $j++;
                    }
                }
                $i++;
            }
            
            fclose($flux);
            return $movies;
        }
        
        /*Cette fonction retourne un string qui représente le poster*/
        function getPosterFromId(string $id){
            $poster = "http://img.omdbapi.com/?i=".$id."&apikey=aef12ffe";
            
            return $poster;
        }
        
        /*Cette fonction permet de selectionner la recherche dans un URL*/
        function hashUrl(string $search): string{
            $url = explode("/infoFilm.php?", $search);

            return $url[1];
        }

        /*Cette fonction retourne une liste de 3 maximum films/series comme choix dans la page infoFilm*/
        function getSameGenreFilm(string $title, string $type, string $id): array{
            $array = array("Title1" => "", "Poster1" => "", "Title2" => "", "Poster2" => "", "Title3" => "", "Poster3" => "", "Id1" => "", "Id2" => "", "Id3" => "");

            //recherche du plus long du titre pour pouvoir chercher des titres par rapport à ce mot
            $title = explode(" ", $title);
            $upperLenght = 0;
            $index = 0;

            for($i = 0; $i < count($title); $i++){
                if(strlen($title[$i]) > $upperLenght){
                   $index = $i;
                   $upperLenght = strlen($title[$i]); 
                }
            }
            $flux = fopen("http://www.omdbapi.com/?apikey=aef12ffe&s=".$title[$index]."&type=".$type."&page=1-100", "r");
            $result = fgets($flux);

            $cut = explode("{\"Title\":\"", $result);
            $size = count($cut) - 1;

            //si jamais le mot clé utiliser nous donne moins de 4(le film ou on est + 3 autre choix) alors on retente avec un autre mot du titre
            if($size < 4){
                $pastTitle = $title[$index];
                fclose($flux);
                $upperLenght = 0;
                $index = 0;

                for($i = 0; $i < count($title); $i++){
                    if(strlen($title[$i]) > $upperLenght && (strcmp($title[$i],$pastTitle) != 0)){
                       $index = $i;
                       $upperLenght = strlen($title[$i]); 
                    }
                }
                $flux = fopen("http://www.omdbapi.com/?apikey=aef12ffe&s=".$title[$index]."&page=1-100", "r");
                $result = fgets($flux);
            }

            //le vrai travail commence
            $cut = explode("{\"Title\":\"", $result);
            $size = count($cut) - 1;

            $firstIndice = rand(1, $size);

            while((stristr($cut[$firstIndice], $id) != false)){
                $firstIndice = rand(1, $size);
            }
            $secondIndice = -1;
            $thirdIndice = -1;
            if($size > 3){
                $secondIndice = rand(1, $size);
                while($secondIndice == $firstIndice || (stristr($cut[$secondIndice], $id) != false)){
                    $secondIndice = rand(1, $size);
                }
            }
            if($size > 4){
                $thirdIndice = rand(1, $size);
                while($thirdIndice == $firstIndice || $thirdIndice == $secondIndice || (stristr($cut[$thirdIndice], $id) != false)){
                    $thirdIndice = rand(1, $size);
                }
            }

            $firstSearch = explode("\",\"", $cut[$firstIndice]);
            $title1 = explode("\":\"", $firstSearch[0]);
            $array["Title1"] = $title1[0];

            $id1 = explode("imdbID\":\"", $firstSearch[2]);
            $array["Id1"] = $id1[1];

            $poster1 = explode("Poster\":\"", $firstSearch[4]);
            $poster1[1] = str_replace("\"},", "", $poster1[1]);
            if(stristr($poster1[1], "totalResults") != false){
                 $array["Poster1"] = "N/A";
            }
            else{
                $array["Poster1"] = $poster1[1];
            }

            if($secondIndice != -1){
                $secondSearch = explode("\",\"", $cut[$secondIndice]);
                $title2 = explode("\":\"", $secondSearch[0]);
                $array["Title2"] = $title2[0];

                $id2 = explode("imdbID\":\"", $secondSearch[2]);
                $array["Id2"] = $id2[1];

                $poster2 = explode("Poster\":\"", $secondSearch[4]);
                $poster2[1] = str_replace("\"},", "", $poster2[1]);
                if(stristr( $poster2[1], "totalResults") != false){
                    $array["Poster2"] = "N/A";
                }
                else{
                    $array["Poster2"] = $poster2[1];
                }
            }

            if($thirdIndice != -1){
                $thirdSearch = explode("\",\"", $cut[$thirdIndice]);
                $title3 = explode("\":\"", $thirdSearch[0]);
                $array["Title3"] = $title3[0];

                $id3 = explode("imdbID\":\"", $thirdSearch[2]);
                $array["Id3"] = $id3[1];

                $poster3 = explode("Poster\":\"", $thirdSearch[4]);
                $poster3[1] = str_replace("\"},", "", $poster3[1]);
                if(stristr($poster3[1], "totalResults") != false){
                    $array["Poster3"] = "N/A";
                }
                else{
                    $array["Poster3"] = $poster3[1];
                }
            }

            fclose($flux);
            return $array;
        }
       
?>