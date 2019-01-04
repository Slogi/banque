
<!DOCTYPE html>
<html lang="fr">
<head>
	<title><?php echo $title ?></title>
	<meta charset="UTF-8" />
    <meta property="og:title" content='<?php echo $ogTitle; ?>' />
    <meta property="og:type" content="music" />
    <meta property="og:url" content="<?php echo $ogUrl; ?>" />
    <meta property="og:image" content="" />
	<link rel="stylesheet" href="skin/poems.css" />
</head>
<body>
	<nav class="menu">
        <?=$form; ?>
		<ul>
<?php
	foreach ($menu as $text => $link) {
		echo "<li><a href=\"$link\">$text</a></li>";
	}
?>
		</ul>
	</nav>
	<main>
		<h1><?php echo $title; ?></h1>
		<p><?php echo $content; ?></p>
	</main>
</body>
</html>

