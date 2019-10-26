<!DOCTYPE html>

<head>
    <meta charset="UTF-8">
    <title>Blabol</title>
    <style>
        .none {
            display: none;
        }
    </style>
</head>

<body>
    <?php
    ini_set('max_execution_time', 0);
    if (!file_exists("slova")) {
        header("Location: slovnik.php?return=true");
    }

    if (isset($_POST["submit"]) and $_POST["reload"]) {
        header("Location: index.php");
    }

    echo '<form method="POST" action="">' . "\n";
    echo '<input class="none" type="text" name="reload" value="true">';
    echo '<input type="submit" name="submit" value="Reload">';
    echo '</form>' . "\n";

    require "functions.php";
    $param = load_csv();

    $i = 0;
    $k = 0;
    $odstavec = rand(5, 15);
    while ($k != $odstavec) {
        $vet = rand(25, 150);
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