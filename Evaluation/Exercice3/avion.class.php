<?php
/*
 * Rouanet Laurent
 * Class Avion
 */ 

class Avion
{
	// Attributs
	private $_nom;
	private $_pays;
	private $_annee;
	private $_constructeur;

	

	public function __construct(array $donnees)
	{
		$this->hydrate($donnees);
	}

	public function hydrate(array $donnees)
	{
		foreach ($donnees as $key => $value) {
			$method = 'set'.ucfirst($key);

			if (method_exists($this, $method))
			{
				$this->$method($value);
			}
		}
	}

	// Getters

	public function getNom()
	{
		return $this->_nom;
	}

	public function getPays()
	{
		return $this->_pays;
	}

	public function getAnnee()
	{
		return $this->_annee;
	}

	public function getConstructeur()
	{
		return $this->_constructeur;
	}


	// Setters
	public function setNom($nom)
	{
		if (is_string($nom))
		{
			$this->_nom = $nom;
		}	
	}

    public function setPays($pays)
	{
		if (is_string($pays))
		{
			$this->_pays = $pays;
		}	
	}

	public function setAnnee($annee)
    {
        $annee = (int) $annee;
        if ($annee > 0)
        {
            $this->_annee = $annee;
        }
    }

	public function setConstructeur($constructeur)
	{
		if (is_string($constructeur))
		{
			$this->_constructeur = $constructeur;
		}	
	}
}
?>
