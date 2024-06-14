<?php

require_once '../../../src/vendor/autoload.php';

use admin\core\services\entree\EntreeServiceNotFoundException;
use admin\core\services\entree\EntreService;
use admin\infrastructure\Eloquent;

Eloquent::init('../../../src/conf/conf.ini');

$entreeService = new EntreService();

try {
    $sql = $entreeService->getEntrees();
} catch (\Exception $e) {
    throw new EntreeServiceNotFoundException('Erreur 404 : Aucune entree trouvée', 404);
}

foreach ($sql as $entree) {
    echo "Nom: ". $entree['nom'] . "\n";
}

?>