<?php 
if($_Permission_->verifPerm('PermsPanel', 'reseaux', 'showPage'))
{
	$nom = htmlspecialchars($_POST['nom']);
	$req = $bddConnection->exec('ALTER TABLE cmw_reseaux ADD '.$nom.' VARCHAR(30)');
}
?>