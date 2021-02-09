<!-- Données et choix du code à exécuter -->
<?php
function validated()
{
    $operations = ['add' => '+', 'mult' => '*', 'sub' => '-', 'div' => '/', 'pow' => '**', 'mod' => '%'];
    if (!array_key_exists($_GET['operation'], $operations)) {
        return ['error' => 'L’operation demandée n’est pas encore prévue par notre système.'];
    }
    if (!is_numeric($_GET['nbr1']) && !is_numeric($_GET['nbr2'])) {
        return ['error' => 'Aucun des nombres fournis n’est valide.'];
    }
    if (!is_numeric($_GET['nbr1'])) {
        return ['error' => 'Le premier nombre n’est pas un nombre valide.'];
    }
    if (!is_numeric($_GET['nbr2'])) {
        return ['error' => 'Le second nombre n’est pas un nombre valide.'];
    }
    if ((float)$_GET['nbr2'] === 0.0 && ($_GET['operation'] === 'div' || $_GET['operation'] === 'mod')) {
        return ['error' => 'Diviser par 0 est une opération qui ne peut pas être réalisée.'];
    }
    $nbr1 = (float)$_GET['nbr1'];
    $nbr2 = (float)$_GET['nbr2'];
    $operation = $_GET['operation'];
    return compact('nbr1', 'nbr2', 'operation');
}


function getResultMessage($nbr1, $nbr2, $operation): string
{
    return match ($operation) {
        'add' => "Additionner ${nbr1} à ${nbr2} vaut ".($nbr1 + $nbr2),
        'sub' => "Soustraire ${nbr2} de ${nbr1} vaut ".($nbr1 - $nbr2),
        'mult' => "Multiplier ${nbr1} par ${nbr2} vaut ".($nbr1 * $nbr2),
        'div' => "Diviser ${nbr1} par ${nbr2} vaut ".($nbr1 / $nbr2),
        'mod' => "Le reste de la division de ${nbr1} par ${nbr2} vaut ".fmod($nbr1, $nbr2),
        'pow' => "${nbr1} exposant ${nbr2} vaut ".($nbr1 ** $nbr2)
    };
}


if (isset($_GET['nbr1'], $_GET['nbr2'], $_GET['operation'])) {
    $old = $_GET;
    $data = validated();
    if (!isset($data['error'])) {
        $resultMessage = getResultMessage($data['nbr1'], $data['nbr2'], $data['operation']);
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
<?php
if (isset($resultMessage)): ?>
    <section class="result">
        <h2>Résultat de votre calcul</h2>
        <p class="calc"><?= $resultMessage ?></p>
    </section>
<?php
elseif (isset($data['error'])): ?>
    <section class="error">
        <h2>Il y a un problème avec vos données</h2>
        <p><?= $data['error'] ?></p>
    </section>
<?php
endif; ?>

<!-- Le formulaire, s’affiche tout le temps -->
<form action="<?= $_SERVER['PHP_SELF'] ?>">
    <fieldset>
        <legend>Entrez les nombres</legend>
        <div>
            <label for="nbr1">Premier nombre</label>
            <input type="text"
                   id="nbr1"
                   value="<?= $old['nbr1'] ?? 0 ?>"
                   name="nbr1"
                   placeholder="4 ou 4.3 par exemple"
                   autofocus>
        </div>
        <div>
            <label for="nbr2">Second nombre</label>
            <input type="text"
                   id="nbr2"
                   value="<?= $old['nbr2'] ?? 0 ?>"
                   name="nbr2"
                   placeholder="4 ou 4.3 par exemple">
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