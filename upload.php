<?php

// Variables globales
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// Vérifie si le fichier image est une image réelle ou une image fausse
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "Le fichier est une image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "Le fichier n'est pas une image.";
        $uploadOk = 0;
    }
}

// Vérifie si aucun fichier n'est choisi
if(strlen($imageFileType) > 0 ){
        // Autorise certains formats de fichier
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif" ) {
            echo "Désolé, seuls les fichiers JPG, JPEG, PNG et GIF sont autorisés.";
            $uploadOk = 0;
        }

         // Vérifie la taille du fichier
        else if ($_FILES["fileToUpload"]["size"] > 500000) {
            echo "Désolé, votre fichier est trop volumineux.";
            $uploadOk = 0;
        }

        // Vérifie si le fichier existe déjà
        else if (file_exists($target_file)) {
            echo "Désolé, le fichier existe déjà.";
            $uploadOk = 0;
        }

        // Vérifie si $uploadOk a la valeur de 0 à cause d'une erreur
        else if ($uploadOk == 0) {
            echo "Désolé, votre fichier n'a pas été téléversé.";

        // Si tout va bien, essaye de téléverser le fichier
        } else {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                echo "SUCCESS";
            } else {
                echo "Désolé, une erreur s'est produite lors du téléversement de votre fichier.";
            }
        }
}
else{
    echo "SUCCESS";
}

