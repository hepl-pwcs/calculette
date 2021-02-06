<!-- Données et choix du code à exécuter -->
<?php
function getResultMessage($nbr1,$nbr2,$operation){
	return match($operation){
		'add' => "Additionner ${nbr1} à ${nbr2} vaut ".($nbr1 + $nbr2), 
		'sub' => "Soustraire ${nbr2} de ${nbr1} vaut ".($nbr1 - $nbr2), 
		'mult' => "Multiplier ${nbr1} par ${nbr2} vaut ".($nbr1 * $nbr2), 
		'div' => "Diviser ${nbr1} par ${nbr2} vaut ".($nbr1 / $nbr2), 
		'mod' => "Le reste de la division de ${nbr1} par ${nbr2} vaut ".($nbr1 % $nbr2), 
		'pow' => "${nbr1} exposant ${nbr2} vaut ".($nbr1 ** $nbr2) 
	};
}

$message = '';
$resultMessage = null;
$nbr1 = $nbr2 = null;
$operations = ['add' => '+', 'mult' => '*', 'sub' => '-', 'div' => '/', 'pow' => '**', 'mod' => '%'];
if (isset($_GET['nbr1'], $_GET['nbr2'], $_GET['operation'])) {
    $nbr1 = $_GET['nbr1'];
    $nbr2 = $_GET['nbr2'];
    if (array_key_exists($_GET['operation'], $operations)) {
        $operation = $_GET['operation'];
        if (is_numeric($nbr1) && is_numeric($nbr2)) {
            //C’est ici qu’on fait le calcul car tout va bien
            $nbr1 = (float) $nbr1;
            $nbr2 = (float) $nbr2;
            if (!$nbr2 && match ($operation) {
                    'div', 'mod' => true,
                    'add', 'sub', 'mult', 'pow' => false
                }) {
                $message = 'Diviser par 0 est une opération qui ne peut pas être réalisée';
            } else {
                $resultMessage = getResultMessage($nbr1,$nbr2,$operation);
            }

        } elseif (!is_numeric($nbr1) && !is_numeric($nbr2)) {
            $message = 'Aucun des nombres fournis n’est valide';
        } elseif (!is_numeric($nbr2)) {
            $message = 'Le second nombre n’est pas un nombre valide.';
        } else {
            $message = 'Le premier nombre n’est pas un nombre valide.';
        }
    } else {
        $message = 'L’operation demandée n’est pas encore prévue par notre système.';
    }
}
?>
<!-- Vue -->
<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="styles.css">
    <title>Calcule-moi ça !</title>
</head>
<body>
<h1>Calcule-moi ça !</h1>
<!-- Le résultat - conditionnel -->
<?php if (!$message && !is_null($resultMessage)): ?>
    <section class="result">
        <h2>Résultat de votre calcul</h2>
        <p class="calc"><?= $resultMessage ?></p>
    </section>
<?php elseif ($message && is_null($resultMessage)): ?>
    <section class="error">
        <h2>Il y a un problème avec vos données</h2>
        <p><?= $message ?></p>
    </section>
<?php endif; ?>

<!-- Le formulaire, s’affiche tout le temps -->
<form action="<?= $_SERVER['PHP_SELF'] ?>">
    <fieldset>
        <legend>Entrez les nombres</legend>
        <div>
            <label for="nbr1">Premier nombre</label>
            <input type="text" id="nbr1" 
            	<?php if(!is_null($nbr1)): ?>value="<?= $nbr1 ?>"<?php endif ?> 
            name="nbr1" placeholder="4 ou 4.3 par exemple" autofocus>
        </div>
        <div>
            <label for="nbr2">Second nombre</label>
            <input type="text" id="nbr2" value="<?= $nbr2 ?>" name="nbr2" placeholder="4 ou 4.3 par exemple">
        </div>
    </fieldset>
    <fieldset>
        <legend>Choisissez une opération</legend>
        <button type="submit" name="operation" value="add">+</button>
        <button type="submit" name="operation" value="sub">-</button>
        <button type="submit" name="operation" value="mult">*</button>
        <button type="submit" name="operation" value="div">/</button>
        <button type="submit" name="operation" value="mod">%</button>
        <button type="submit" name="operation" value="pow">**</button>
    </fieldset>
</form>
</body>
</html>