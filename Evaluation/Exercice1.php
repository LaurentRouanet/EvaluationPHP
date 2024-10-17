<?php

/**
 * ROUANET Laurent
 * Classe abstraite Vehicule.
 *
 * Cette classe sert de modèle pour les classes dérivées (comme Voiture).
 * Elle définit des propriétés et méthodes communes à tous les véhicules.
 * 
 */

abstract class Vehicule 
{
    /**
     * @var bool Indique si le véhicule est démarré ou non.
     */
    protected $demarrer = FALSE;

    /**
     * @var int La vitesse actuelle du véhicule.
     */
    protected $vitesse = 0;

    /**
     * @var int La vitesse maximale du véhicule.
     */
    protected $vitesseMax;

    /**
     * @var bool Indique si le frein de stationnement est activé.
     */
    protected $freinStationnement = FALSE;

    /**
     * Méthode abstraite pour démarrer le véhicule.
     *
     * @return void
     */
    abstract public function demarrer();

    /**
     * Méthode abstraite pour éteindre le véhicule.
     *
     * @return void
     */
    abstract public function eteindre();

    /**
     * Méthode abstraite pour décélérer le véhicule.
     *
     * @param int $vitesse La vitesse à retirer.
     * @return void
     */
    abstract public function decelerer($vitesse);

    /**
     * Méthode abstraite pour accélérer le véhicule.
     *
     * @param int $vitesse La vitesse à ajouter.
     * @return void
     */
    abstract public function accelerer($vitesse);

    /**
     * Méthode magique toString pour afficher les informations sur le véhicule.
     *
     * @return string Informations sur le véhicule.
     */
    public function __toString()
    {
        $chaine = "Ceci est un véhicule <br/>";
        $chaine .= "---------------------- <br/>";
        $chaine .= "Vitesse actuelle : " . $this->vitesse . " km/h<br/>";
        $chaine .= "Frein de stationnement : " . ($this->freinStationnement ? "Activé" : "Désactivé") . "<br/>";
        return $chaine;
    }
}

/**
 * Classe Voiture qui hérite de la classe abstraite Vehicule.
 *
 * Implémentation des méthodes abstraites définies dans la classe Vehicule.
 */
class Voiture extends Vehicule 
{
    /**
     * @var int Affichafe du nombre de voitures instanciées.
     */
    private static $nombreVoiture = 0;

    /**
     * Constructeur de la classe Voiture.
     *
     * @param int $vitesseMax La vitesse maximale de la voiture.
     */
    public function __construct($vitesseMax) {
        $this->vitesseMax = $vitesseMax;
        self::$nombreVoiture++;
    }

    /**
     * Démarre la voiture.
     *
     * @return void
     */
    public function demarrer() {
        if ($this->freinStationnement) {
            echo "Impossible de démarrer, le frein de stationnement est activé.<br/>";
        } else {
            $this->demarrer = TRUE;
            echo "La voiture a démarré.<br/>";
        }
    }

    /**
     * Éteint la voiture.
     *
     * @return void
     */
    public function eteindre() {
        $this->demarrer = FALSE;
        echo "La voiture est éteinte.<br/>";
    }

    /**
     * Active ou désactive le frein de stationnement.
     *
     * @param bool $activer Si vrai, active le frein ; sinon le désactive.
     * @return void
     */
    public function activerFreinStationnement($activer) {
        if ($this->vitesse == 0) {
            $this->freinStationnement = $activer;
            echo "Frein de stationnement " . ($activer ? "activé" : "désactivé") . ".<br/>";
        } else {
            echo "Impossible d'activer le frein de stationnement lorsque la voiture est en mouvement.<br/>";
        }
    }

    /**
     * Accélère la voiture.
     *
     * @param int $vitesse La vitesse à ajouter.
     * @return void
     */
    public function accelerer($vitesse) {
        if (!$this->demarrer) {
            echo "Impossible d'accélérer, la voiture est éteinte.<br/>";
            return;
        }

        if ($this->freinStationnement) {
            echo "Impossible d'accélérer, le frein de stationnement est activé.<br/>";
            return;
        }

        if ($this->vitesse == 0 && $vitesse > 10) {
            $vitesse = 10; // Limite d'accélération depuis l'arrêt
        } elseif ($vitesse > $this->vitesse * 0.3) {
            $vitesse = (int)($this->vitesse * 0.3); // Limite d'accélération de 30%
        }

        $this->vitesse += $vitesse;
        if ($this->vitesse > $this->vitesseMax) {
            $this->vitesse = $this->vitesseMax;
        }
        echo "La voiture accélère à {$this->vitesse} km/h.<br/>";
    }

    /**
     * Décélère la voiture.
     *
     * @param int $vitesse La vitesse à retirer.
     * @return void
     */
    public function decelerer($vitesse) {
        if (!$this->demarrer) {
            echo "Impossible de décélérer, la voiture est éteinte.<br/>";
            return;
        }

        if ($vitesse > 20) {
            $vitesse = 20; // Limite de décélération de 20 km/h
        }

        $this->vitesse -= $vitesse;
        if ($this->vitesse < 0) {
            $this->vitesse = 0;
        }
        echo "La voiture décélère à {$this->vitesse} km/h.<br/>";
    }

    /**
     * Retourne le nombre de voitures instanciées.
     *
     * @return int Le nombre de voitures.
     */
    public static function getNombreVoiture() {
        return self::$nombreVoiture;
    }
}

// Exemple d'utilisation et tests des nouvelles règles
$veh1 = new Voiture(110);
$veh1->demarrer();
$veh1->accelerer(40); // Limité à 10 km/h car voiture à l'arrêt
echo $veh1;
$veh1->accelerer(40); // Limité à 30% de la vitesse actuelle
echo $veh1;
$veh1->accelerer(12); // Pas de limitation, en dessous de 30%
$veh1->accelerer(40); // Limité à 30% de la nouvelle vitesse
echo $veh1;
$veh1->accelerer(40); // Limité à la vitesse max
$veh1->decelerer(120); // Limité à 20 km/h de décélération
echo $veh1;

$veh1->activerFreinStationnement(TRUE); // Impossible d'activer en mouvement
$veh1->decelerer(30); // Limite de décélération
$veh1->activerFreinStationnement(TRUE); // Frein activé
$veh1->accelerer(40); // Frein activé donc impossible

$veh2 = new Voiture(180);
echo $veh2;

echo "############################ <br/>";
echo "Nombre de voitures instanciées : " . Voiture::getNombreVoiture() . "<br/>";

