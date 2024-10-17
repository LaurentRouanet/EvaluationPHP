<?php
class AvionManager
/**
 * ROUANET Laurent
 * Classe AvionManager
 * 
 * Il s'agit du manager de la classe avion.
 * Elle permet de gérer les methodes relatives à la classe avion.
 */
{
	private $_db;

	public function __construct($db)
	{
		$this->setDB($db);
	}

	public function add(Avion $avion)
	{
		$q = $this->_db->prepare('INSERT INTO avion(nom,pays,annee,constructeur) VALUES(:nom, pays, :annee, :constructeur)');
		$q->bindValue(':nom', $avion->getNom());
		$q->bindValue(':pays', $avion->getPays());
		$q->bindValue(':annee', $avion->getAnnee());
		$q->bindValue(':constructeur', $avion->getConstructeur());
        $q->execute();

		$avion->hydrate([
			'Id' => $this->_db->lastInsertId(),
			'Avion' => 0]);
		}

	public function setDb(PDO $db)
	{
		$this->_db = $db;
	}
}

?>
*/