<?php
    define("MAX_COMPTEUR_VUE", 10);

    /*Cette fonction retourne au cours des MAX_COMPTEUR_VUE dernières actualisation*/
    function getNumberVisitor(): array{
        $fichier = fopen("./fichier/visiteur.txt", "r");
        $number = array();
        $compteur = 0;

        $value = fgets($fichier);

        while($value != false && $compteur < MAX_COMPTEUR_VUE){
            $split = explode(":", $value);
            if(strlen($value) > 1 && intval($split["1"]) < 2000){
                $number["".$compteur] = $value;
                $compteur++;
            }
            $value = fgets($fichier);
        }

        fclose($fichier);

        return $number;
    }

    /*Cette fonction retourne le nombre max de visiteur sur tout le temps*/
    function getVisitorNumber(): string{
         $fichier = fopen("./fichier/visiteur.txt", "r");

         $nombre = 0;
         $value = fgets($fichier);
         while($value != false){
            $split = explode(":", $value);
            if(isset($split["1"])){
                $nombre += intval($split["1"]);
            }
            $value = fgets($fichier);
         }

         fclose($fichier);

         return $nombre;
    }

    /*Cette fonction augmente le nombre de visiteurs du site*/
    function addVisitorStat(){
        $fichier = fopen("./fichier/visiteur.txt", "r");

        $arrayVistor = array();
        $size = 0;
        $arrayVistor[$size] = fgets($fichier);

        if($arrayVistor[$size] != false && stristr($arrayVistor[$size], date("Y-m-d"))){
            $chaineBis = explode(":", $arrayVistor[$size]);
            $number = intval($chaineBis["1"]) + 1;
            $arrayVistor[$size] = $chaineBis["0"].":".$number;
            $size += 1;
        }
        else{
            $arrayVistor[$size + 1] = $arrayVistor[$size];
            $arrayVistor[$size] = date("Y-m-d").":1";
            $size += 2;
        }
        $arrayVistor[$size] = fgets($fichier);
        while($arrayVistor[$size] != false){
            $size += 1;
            $arrayVistor[$size] = fgets($fichier);
        }

        fclose($fichier);

        $fichier = fopen("./fichier/visiteur.txt", "w");
        fputs($fichier, $arrayVistor["0"]."\n");

        for($i = 1; $i < count($arrayVistor); $i++){
            fputs($fichier, $arrayVistor[$i]);
        }

        fclose($fichier);
    }

    /*cette fonction detecte le navigateur*/
    function getBrowser(): string{
    	$var =  getenv("HTTP_USER_AGENT");
    	if(strpos($var, "Chrome")){
    		$brower = "\t\t<p class=\"text\">navigateur : Chrome</p>\n";
    	}
    	else if(strpos($var, "Firefox")){
    		$brower = "\t\t<p class=\"text\">navigateur : Firefox</p>\n";
    	}
    	else if(strpos($var, "Mac")){
    		$brower = "\t\t<p class=\"text\">navigateur : Mac</p>\n";
    	}
    	else if(strpos($var, "Opera")){
    		$brower = "\t\t<p class=\"text\">navigateur : Opera</p>\n";
    	}
    	else if(strpos($var, "Safari")){
    		$brower = "\t\t<p class=\"text\">navigateur : Safari</p>\n";
    	}
    	else{
    		$brower = "\t\t<p class=\"text\">navigateur : non reconnus</p>\n";
    	}

    	return $brower;
    }
?>
