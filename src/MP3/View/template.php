
<!DOCTYPE html>
<html lang="fr">
<head>
    <title><?php echo $title ?></title>
    <meta charset="UTF-8" />
    <?php echo $meta; ?>
    <link rel="stylesheet" href="skin/poems.css" />




</head>
<body>
    <nav class="menu">
        <?php echo $form; ?>
        <ul>
<?php
foreach ($menu as $text => $link) {
    echo "<li><a href=\"$link\">$text</a></li> ";

}
?>
        </ul>
    </nav>
    <main>
        <h1><?php echo $title; ?></h1>
        <span class="player"><?php echo $player; ?></span>

    <?php echo $content; ?>
    </main>
    <?php echo $formBuy; ?>
    <?php echo $formModif; ?>




</body>
</html>

