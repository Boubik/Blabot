<!DOCTYPE html>

<head>
    <meta charset="UTF-8">
    <title>Blabol</title>
</head>

<body>
    <?php
    ini_set('max_execution_time', 0);
    if (!file_exists("slova")) {
        header("Location: slovnik.php?return=true");
    }

    require "functions.php";
    $param = load_csv();

    if (isset($_GET["odstavec"])) {
        $odstavec = filter_input(INPUT_GET, "odstavec");
        if ($odstavec < 1) {
            $odstavec = 4;
        }
    } else {
        $odstavec = 4;
    }
    if (isset($_GET["vet"])) {
        $vet = filter_input(INPUT_GET, "vet");
        if ($vet < 1) {
            $vet = 40;
        }
    } else {
        $vet = 40;
    }

    echo '<form method="GET" action="">';
    echo 'Vět v odstavci <input type="number" name="vet" value="' . $vet . '">' . "<br>\n";
    echo 'Odstavců<input type="number" name="odstavec" value="' . $odstavec . '">' . "<br>\n";
    echo '<input type="submit" name="submit" value="Nastavit/Reload">';
    echo '</form>';
    echo "<br>\n";
    echo "<br>\n";

    $i = 0;
    $k = 0;
    while ($k != $odstavec) {
        while ($i != $vet) {
            if ($i == 0) {
                echo "<p>";
            }
            $sentence = generate_sentence($param[rand(0, count($param) - 1)]);
            echo mb_ucfirst(strtolower($sentence)) . " ";
            $i++;
        }
        echo "</p>";
        $i = 0;
        $k++;
    }

    ?>
</body>

</html>