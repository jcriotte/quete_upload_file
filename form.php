<?php
// define variables and set to empty values
$firstNameErr = $lastNameErr = $fileErr = $retour = "";
$firstName = $lastName = "";
//Tableau des extensions que l'on accepte
$extensions = ['jpg', 'png', 'webp'];
//Taille max que l'on accepte
$maxSize = 1000000;


//echo $_SERVER["REQUEST_METHOD"]; 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["firstname"])) {
        //echo "first name est vide";
        $firstNameErr = "First Name is required<br>";
        echo $firstNameErr;
        //$previous = $_SERVER['HTTP_REFERER'];
        //echo $previous;
    } else {
        $firstName = filter_var(
            $_POST["firstname"],
            FILTER_CALLBACK,
            array("options" => "strtoupper")
        );
    }

    if (empty($_POST["lastname"])) {
        $lastNameErr = "Last Name is required<br>";
        echo $lastNameErr;
    } else {
        $lastName = filter_var(
            $_POST["lastname"],
            FILTER_CALLBACK,
            array("options" => "strtoupper")
        );
    }
    //récuperation des valeurs du $_FILES pour le fichier upload.
    $tmpName = $_FILES['photo']['tmp_name'];
    $name = $_FILES['photo']['name'];
    $size = $_FILES['photo']['size'];
    $error = $_FILES['photo']['error'];
    $retour = "";

    $tabExtension = explode('.', $name);
    $extension = strtolower(end($tabExtension));

    if (in_array($extension, $extensions) && $size <= $maxSize && $error == 0) {
        $uniqueName = uniqid('', true);
        //uniqid génère quelque chose comme ca : 5f586bf96dcd38.73540086
        $file = $uniqueName . "." . $extension;
        //$file = 5f586bf96dcd38.73540086.jpg
        move_uploaded_file($tmpName, './upload/' . $file);
    } else {
        $fileErr = "Mauvaise extension ou taille trop grande";
    }
    if (empty($firstNameErr) && empty($lastNameErr) && empty($fileErr)) {
        $retour = "Merci pour votre inscription !";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>SpringfieldWild</title>
    <link rel="stylesheet" type="text/css" href="form.css">
    <link rel="stylesheet" type="text/css" href="/header.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&family=Poppins:wght@100&display=swap" rel="stylesheet">
    <?php
    // set the default timezone to use.
    date_default_timezone_set('UTC');
    ?>
</head>

<body>

    <!-- Article dans l'index -->

    <h1>SpringfieldWild, inscription</h1>

    <section class="lastArticle container">
        <div>
            <p><?php if ($retour != "") {
                ?>
            <p><?php echo $retour; ?></p>
            <p><?php echo $firstName; ?></p>
            <p><?php echo $lastName; ?></p>
            <img src="<?php echo './upload/' . $file ?>">
        <?php
                } else {
        ?><p><?php echo $fileErr; ?></p>
            <p><?php echo $firstNameErr ?></p>
            <p><?php echo $lastNameErr; ?></p>
        <?php
                }
        ?>
        </div>
    </section>

    <section class="lastArticle container">

        <form class="formsuggest" method="POST" enctype="multipart/form-data">

            <div class="firstname formsuggest">
                <label for="firstname">Nom : </label>
                <input type="text" name="firstname" id="firstname" maxlength=50 required>
            </div>

            <div class="lastname formsuggest">
                <label for="lastname">Prénom : </label>
                <input type="text" name="lastname" id="lastname" maxlength=50 required>
            </div>

            <div class="photo form">
                <label for="photo">Photo pour ton profitl : </label>
                <input type="file" name="photo" id="photo" required>
            </div>
            <div class="button">
                <input type="submit" value="Soumettre votre inscription !">
            </div>

        </form>

    </section>

</body>

</html>