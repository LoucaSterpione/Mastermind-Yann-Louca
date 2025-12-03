<?php

// ===================================================================================
// 1. BLOC DE CONFIGURATION ET D'INITIALISATION
// ===================================================================================

// Définition des constantes pour la configuration du jeu
const LONGUEUR_CODE = 4;
const MAX_TENTATIVES = 12;

// Tableaux indexés des couleurs disponibles
// NOTE: Les deux tableaux doivent avoir le même ordre pour maintenir la correspondance !
$initialesCouleurs = ['R', 'V', 'B', 'J', 'P', 'N']; // Les initiales que le joueur saisit
$emojisCouleurs = ['🔴', '🟢', '🔵', '🟡', '🟣', '⚫']; // Les emojis pour l'affichage

// Emojis pour les indices
const CLE_BIEN_PLACE = '🔑';
const PION_MAL_PLACE = '⚪';

echo "
================================================================
           MASTERMIND EN CONSOLE PHP (BTS SIO 1)
================================================================
Objectif : Deviner la combinaison secrète de " . LONGUEUR_CODE . " pions en " . MAX_TENTATIVES . " tentatives maximum.
Couleurs disponibles : ";


foreach ($initialesCouleurs as $index => $initiale) {
    echo $initiale . " (" . $emojisCouleurs[$index] . ") ";
}
echo "\n================================================================\n";

// ===================================================================================
// 2. GÉNÉRATION DE LA COMBINAISON SECRÈTE
// ===================================================================================

$combinaisonSecrete = [];

for ($i = 0; $i < LONGUEUR_CODE; $i++) {
    $indexAleatoire = array_rand($initialesCouleurs);
    $combinaisonSecrete[] = $initialesCouleurs[$indexAleatoire];
}

// ===================================================================================
// 3. BOUCLE PRINCIPALE DU JEU
// ===================================================================================

$victoire = false;
// La boucle tourne tant que le joueur n'a pas gagné et que le nombre max de tentatives n'est pas atteint
for ($tentative = 1; $tentative <= MAX_TENTATIVES; $tentative++) {
    echo "\n---  Tentative  $tentative  / " . MAX_TENTATIVES . " ---\n";
}

// -------------------------------------------------------------------------------
// 3.1. BLOC DE SAISIE ET VALIDATION
// -------------------------------------------------------------------------------

$proposition= [];
$valide = false;

while (!$valide) {
    
    $saisie = readline("Entrez votre proposition  (ex: 4 initiales, RVBJ) : ");
    $saisie = strtoupper(str_replace(' ', '', $saisie)); 
}
    if (strlen($saisie) !== LONGUEUR_CODE) {
        echo "Erreur : Vous devez entrer exactement " . LONGUEUR_CODE . " caractères.\n";
    }
    
    $caractere = str_split($saisie);


    foreach ($caractere as $initiale) {
        if (!in_array($initiale, $initialesCouleurs)) {
            echo "Erreur : Le caractère '" . $initiale . "' n'est pas valide. Couleurs valides : " . implode(', ', $initialesCouleurs) . ".\n";
            $caractereValide = false;
            break;
        }
    }

if (!$caractereValide) {
        
    }

    $proposition = str_split($saisie);
    $valide = true;



// -------------------------------------------------------------------------------
// 3.2. BLOC D'ANALYSE (ALGORITHME MASTERMIND)
// -------------------------------------------------------------------------------

$bienPlace = 0;
$malPlace = 0;

// On sauvegarde la proposition pour l'affichage (elle sera modifiée pendant les calculs)
$propositionAffichage = $proposition;

// On fait une copie de la combinaison secrète pour pouvoir marquer (mettre à null) les pions
// qui ont déjà été utilisés sans modifier l'original, ce qui permet de respecter
// la règle du compte unique de Mastermind.
// NOTE: $proposition peut être modifiée directement car elle est réinitialisée à chaque tentative.
$secreteTravail = $combinaisonSecrete;

// ÉTAPE 1 : CALCUL DES BIEN PLACÉ (Clés Noires 🔑)
// On utilise un simple "for" pour comparer position par position.

for ($i = 0; $i < LONGUEUR_CODE; $i++) {
    if ($proposition[$i]===$secreteTravail[$i]){
        $bienPlace++;
        $proposition[$i] = null;
        $secreteTravail[$i] = null;
    }
}
// ÉTAPE 2 : CALCUL DES MAL PLACÉ (Pions Blancs ⚪)
// On compare les éléments non NULL restants.

foreach ($proposition as $couleurPropre) {
    if ($couleurPropre !== null) {
        $indexTrouve = array_search($couleurPropre, $secreteTravail);
        if ($indexTrouve !== false) {
            $malPlace++;
            $secreteTravail[$indexTrouve] = null;
        }
    }
}

// -------------------------------------------------------------------------------
// 3.3. BLOC D'AFFICHAGE ET GESTION DE LA FIN DE PARTIE
// -------------------------------------------------------------------------------

// Affichage de la proposition du joueur en emojis

// VOTRE CODE ICI
$affichageProposition = '';
foreach ($propositionAffichage as $initiale) {
    $indexEmoji = array_search($initiale, $initialesCouleurs);
    $emoji=$emojisCouleurs[$indexEmoji];
    $affichageProposition .= $emoji . " ";
}

// Affichage des indices

// VOTRE CODE ICI
$affichageIndices = str_repeat(CLE_BIEN_PLACE, $bienPlace) . str_repeat(PION_MAL_PLACE, $malPlace);
echo "Votre proposition : " . $affichageProposition . "\n";
echo "Indices : " . $affichageIndices . "\n";

// Vérification de la condition de victoire

if ($bienPlace === LONGUEUR_CODE) {
    $victoire = true;
    // Sortie de la boucle principale
}

// Fin de la boucle principale

// ===================================================================================
// 4. BLOC DE RÉSULTAT FINAL
// ===================================================================================

// Affichage de la combinaison secrète à la fin (Victoire ou Défaite)

// VOTRE CODE ICI
$affichageSecrete = '';
foreach ($combinaisonSecrete as $initiale) {
    $indexEmoji = array_search($initiale, $initialesCouleurs);
    $emoji .= $emojisCouleurs[$indexEmoji];
    $affichageSecrete .= $emoji . " ";

echo "\n================================================================\n";

} if ($victoire) {
    echo "🎉 FÉLICITATIONS ! Vous avez trouvé la combinaison secrète en  $tentatives tentatives !". "\n";
    } else {
        echo "😭 DOMMAGE ! Vous avez atteint le max de " . MAX_TENTATIVES . " tentatives \n";
    }
    echo "La combinaison secrète était : " . $affichageSecrete . "\n";
    echo "================================================================\n";

