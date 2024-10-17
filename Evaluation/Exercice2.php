<?php

/**
 * ROUANET Laurent
 * Classe abstraite Vehicule.
 *
 * Cette classe sert de modèle pour les classes dérivées (comme Avion).
 * 
 */

abstract class Vehicule 
{
    protected $demarrer = FALSE;
    protected $vitesse = 0;
    protected $vitesseMax;

    // On oblige les classes filles à définir les méthodes abstract
    abstract function decelerer($vitesse);
    abstract function accelerer($vitesse);

    // Fonction pour démarrer le véhicule
    public function demarrer() 
    {
        $this->demarrer = TRUE;
        echo "Le véhicule a démarré.<br/>";
    }

    // Fonction pour éteindre le véhicule
    public function eteindre() 
    {
        $this->demarrer = FALSE;
        echo "Le véhicule est éteint.<br/>";
    }

    // Vérifier si le véhicule est démarré
    public function estDemarre() 
    {
        return $this->demarrer;
    }

    // Vérifier si le véhicule est éteint
    public function estEteint() 
    {
        return !$this->demarrer;
    }

    // Obtenir la vitesse actuelle
    public function getVitesse() 
    {
        return $this->vitesse;
    }

    // Obtenir la vitesse maximale
    public function getVitesseMax() 
    {
        return $this->vitesseMax;
    }

    // Méthode magique toString pour afficher un véhicule
    public function __toString() 
    {
        $chaine = "Ceci est un véhicule <br/>";
        $chaine .= "---------------------- <br/>";
        return $chaine;
    }
}

/**
 * Avion hérite de Vehicule
 * Avion avec caractéristiques spécifiques comme altitude, plafond, train d'atterissage
 */
class Avion extends Vehicule 
{
    private $altitude = 0;
    private $plafond;
    private $trainAtterrissageSorti = TRUE; // Par défaut, le train d'atterrissage est sorti.
    private const PLAFOND_MAX = 40000; // Le plafond maximal pour tous les avions.
    private const VITESSE_MAX_AVION = 2000; // La vitesse maximale pour tous les avions.

    /**
     * Constructeur de la classe Avion
     * 
     * @param int $vitesseMax La vitesse maximale de l'avion.
     * @param int $plafond L'altitude maximale de l'avion.
     */
    public function __construct($vitesseMax, $plafond) {
        $this->vitesseMax = min($vitesseMax, self::VITESSE_MAX_AVION); // Limite de la vitesse max 
        $this->plafond = min($plafond, self::PLAFOND_MAX); // Limite du plafond 
        echo "Un nouvel avion est créé avec une vitesse max de {$this->vitesseMax} km/h et un plafond de {$this->plafond} mètres.<br/>";
    }

    /**
     * Décollage de l'avion
     * L'avion décolle uniquement si sa vitesse est d'au moins 120 km/h.
     */
    public function decoller() {
        if ($this->vitesse >= 120) {
            $this->altitude = 100; // Le décollage fait passer l'altitude à 100 mètres.
            echo "L'avion a décollé et est à une altitude de {$this->altitude} mètres.<br/>";
        } else {
            echo "Impossible de décoller. La vitesse doit être d'au moins 120 km/h.<br/>";
        }
    }

    /**
     * Atterrissage l'avion
     * L'avion ne peut atterrir que si sa vitesse est entre 80 et 110 km/h, que son altitude est entre 50 et 150 mètres, et que le train d'atterrissage est sorti.
     */
    public function atterrir() {
        if ($this->trainAtterrissageSorti && $this->vitesse >= 80 && $this->vitesse <= 110 && $this->altitude >= 50 && $this->altitude <= 150) {
            $this->vitesse = 0;
            $this->altitude = 0;
            echo "L'avion a atterri avec succès. Vitesse et altitude sont maintenant à 0.<br/>";
        } else {
            echo "Impossible d'atterrir. Vérifiez la vitesse, l'altitude et le train d'atterrissage.<br/>";
        }
    }

    /**
     * Prendre de l'altitude
     * L'avion ne peut pas prendre de l'altitude si le train d'atterrissage est sorti ou s'il n'a pas décollé.
     * 
     * @param int $altitude L'altitude à ajouter.
     */
    public function prendreAltitude($altitude) {
        if ($this->altitude == 0) {
            echo "Impossible de prendre de l'altitude. L'avion n'a pas encore décollé.<br/>";
        } elseif ($this->trainAtterrissageSorti) {
            echo "Impossible de prendre de l'altitude avec le train d'atterrissage sorti.<br/>";
        } else {
            $nouvelleAltitude = $this->altitude + $altitude;
            if ($nouvelleAltitude > $this->plafond) {
                $this->altitude = $this->plafond;
                echo "L'avion est maintenant à son plafond de {$this->plafond} mètres.<br/>";
            } else {
                $this->altitude = $nouvelleAltitude;
                echo "L'avion a pris de l'altitude et est maintenant à {$this->altitude} mètres.<br/>";
            }
        }
    }

    /**
     * Perdre de l'altitude
     * L'avion ne peut pas perdre d'altitude s'il n'a pas encore décollé.
     * 
     * @param int $altitude L'altitude à retirer.
     */
    public function perdreAltitude($altitude) {
        if ($this->altitude == 0) {
            echo "Impossible de perdre de l'altitude. L'avion n'a pas encore décollé.<br/>";
        } else {
            $nouvelleAltitude = $this->altitude - $altitude;
            if ($nouvelleAltitude < 0) {
                $this->altitude = 0;
                echo "L'avion est maintenant au sol (altitude de 0 mètre).<br/>";
            } else {
                $this->altitude = $nouvelleAltitude;
                echo "L'avion a perdu de l'altitude et est maintenant à {$this->altitude} mètres.<br/>";
            }
        }
    }

    /**
     * Sortir le train d'atterrissage
     */
    public function sortirTrainAtterrissage() {
        $this->trainAtterrissageSorti = TRUE;
        echo "Le train d'atterrissage est sorti.<br/>";
    }

    /**
     * Rentrer le train d'atterrissage
     */
    public function rentrerTrainAtterrissage() {
        if ($this->altitude > 300) {
            $this->trainAtterrissageSorti = FALSE;
            echo "Le train d'atterrissage est rentré.<br/>";
        } else {
            echo "Impossible de rentrer le train d'atterrissage à une altitude inférieure à 300 mètres.<br/>";
        }
    }

    /**
     * Accélération de l'avion
     * 
     * @param int $vitesse La vitesse à ajouter.
     */
    public function accelerer($vitesse) {
        $this->vitesse += $vitesse;
        if ($this->vitesse > $this->vitesseMax) {
            $this->vitesse = $this->vitesseMax;
        }
        echo "L'avion accélère et atteint {$this->vitesse} km/h.<br/>";
    }

    /**
     * Décélérationb de l'avion
     * 
     * @param int $vitesse La vitesse à retirer.
     */
    public function decelerer($vitesse) {
        $this->vitesse -= $vitesse;
        if ($this->vitesse < 0) {
            $this->vitesse = 0;
        }
        echo "L'avion décélère et atteint {$this->vitesse} km/h.<br/>";
    }
}

// Tests
$avion = new Avion(1800, 35000);
$avion->demarrer();
$avion->accelerer(150); // Pas assez pour décoller
$avion->decoller();
$avion->accelerer(150); // Maintenant assez pour décoller
$avion->decoller();
$avion->prendreAltitude(5000);
$avion->rentrerTrainAtterrissage(); // Impossible car en dessous de 300 mètres
$avion->prendreAltitude(400);
$avion->rentrerTrainAtterrissage();
$avion->decelerer(100);
$avion->sortirTrainAtterrissage();
$avion->atterrir(); // Impossible car vitesse trop élevée
$avion->decelerer(110); // Maintenant en bonne vitesse
$avion->atterrir();
