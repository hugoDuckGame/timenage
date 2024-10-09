<head> 
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../main.css">
    <link rel="stylesheet" href="style.css">
    <title>Home - DG Timenage</title>
    <link rel="icon" type="image/x-icon" href="duck-icon.ico">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
</head>
<body>
<div id="alertbox"></div>
<?php
include '../vars.php';

// Create connection
$conn = new mysqli($exosv, $exous, $exopw, $exodb);
$conn->set_charset("utf8mb4");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "
    SELECT 
        m.unicid AS subject_id,  -- Ajoute l'unicid de la matière
        m.Value AS subject,
        t.unicid AS theme_id,     -- Ajoute l'unicid du thème
        t.Value AS theme,
        c.unicid AS chapter_id,   -- Ajoute l'unicid du chapitre
        c.Value AS chapter,
        a.Value AS other
    FROM 
        proj m
    LEFT JOIN 
        proj t ON t.subject = m.unicid AND t.type = 2 -- Thèmes liés à la matière
    LEFT JOIN 
        proj c ON c.theme = t.unicid AND c.type = 3 -- Chapitres liés au thème
    LEFT JOIN 
        proj a ON a.chapter = c.unicid AND a.type = 4 -- Autres liés au chapitre
    WHERE 
        m.type = 1 -- Sélectionne les matières
    ORDER BY 
        m.Value,      -- Trie les matières par nom
        t.Value,      -- Trie les thèmes par nom
        c.unicid,     -- Trie les chapitres par identifiant unique
        a.Value       -- Trie les autres par nom
";

$result = $conn->query($sql);

$testSubj = null;
$testTheme = null;
$counter = 0;

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        // Vérifie si les valeurs existent avant de les afficher
        $subject = isset($row["subject"]) ? $row["subject"] : "";
        $theme = isset($row["theme"]) ? $row["theme"] : "";
        $chapter = isset($row["chapter"]) ? $row["chapter"] : "";
        $c_id = isset($row["chapter_id"]) ? $row["chapter_id"] : "";
        $t_id = isset($row["theme_id"]) ? $row["theme_id"] : "";

        // Affichage de la matière
        if($subject != $testSubj && $subject != ""){
            // Ferme le div de la matière précédente
            if ($testSubj !== null) {
                echo ""; // Ferme le div précédent
            }
            echo "</div><div class='card'><br><h5>{$subject}</h5>"; // Ouvre le div pour le sujet
            $testSubj = $subject;
            $counter++; // Incrémente le compteur pour les ID uniques
        }

        // Affichage du thème
        if($theme != $testTheme && $theme != ""){
            if ($testTheme !== null) {
                echo ""; // Ferme le div précédent du thème
            }
            echo "<br><a href='project.php?project={$t_id}'><h3>{$theme}</h3></a>"; // Ouvre le div pour le thème
            $testTheme = $theme;
            $counter++;
        }

        // Affichage du chapitre
        if($chapter != ""){ // Affiche le chapitre s'il existe
            echo "<br><a href='project.php?project={$c_id}'><h4>{$chapter}</h4></a>"; // Ouvre le div pour le chapitre
            $counter++;
        }
    }


} else {
    echo "<div class='container'>0 results</div>";
}

$conn->close();
?>
</body>
