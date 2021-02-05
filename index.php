<!-- Données et choix du code à exécuter -->
<?php
$message = '';
$result = null;
$nbr1 = $nbr2 = 0;
$operations = ['add' => '+', 'mult' => '*', 'sub' => '-', 'div' => '/', 'pow' => '**', 'mod' => '%'];
if (isset($_GET['nbr1'], $_GET['nbr2'], $_GET['operation'])) {
    if (array_key_exists($_GET['operation'], $operations)) {
        $operation = $_GET['operation'];
        if (is_numeric($_GET['nbr1']) && is_numeric($_GET['nbr2'])) {
            //C’est ici qu’on fait le calcul car tout va bien
            $nbr1 = (float) $_GET['nbr1'];
            $nbr2 = (float) $_GET['nbr2'];
            if (!$nbr2 && match ($operation) {
                    'div', 'mod' => true,
                    'add', 'sub', 'mult', 'pow' => false
                }) {
                $message = 'Diviser par 0 est une opération qui ne peut pas être réalisée';
            } else {
                $result = match ($operation) {
                    'add' => $nbr1 + $nbr2,
                    'mult' => $nbr1 * $nbr2,
                    'sub' => $nbr1 - $nbr2,
                    'div' => $nbr1 / $nbr2,
                    'mod' => $nbr1 % $nbr2,
                    'pow' => $nbr1 ** $nbr2
                };
            }

        } elseif (!is_numeric($_GET['nbr1']) && !is_numeric($_GET['nbr2'])) {
            $message = 'Aucun des nombres fourni n’est valide';
        } elseif (!is_numeric($_GET['nbr2'])) {
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
    <title>Calcule-moi ça !</title>
</head>
<body>
<h1>Super calculette à cinq opérations</h1>
<!-- Le résultat - conditionnel -->
<?php if (!$message && !is_null($result)): ?>
    <section>
        <h2>Résultat de votre calcul</h2>
        <p><?= $nbr1 ?> <?= $operations[$operation] ?> <?= $nbr2 ?> = <?= $result ?></p>
    </section>
<?php elseif ($message && is_null($result)): ?>
    <section>
        <h2>Il y a un problème avec vos données</h2>
        <p><?= $message ?></p>
    </section>
<?php endif; ?>
<form action="<?= $_SERVER['PHP_SELF'] ?>">
    <fieldset>
        <legend>Entrez les nombres</legend>
        <div>
            <label for="nbr1">Premier nombre</label>
            <input type="text" id="nbr1" value="<?= $nbr1 ?>" name="nbr1" placeholder="4 ou 4.3 par exemple">
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
        <button type="submit" name="operation" value="pow">^</button>
    </fieldset>
</form>
</body>
</html>