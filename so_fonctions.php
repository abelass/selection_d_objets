<?php


/* Fonction qui traduit les champs */
function info_objet($id_objet,$objet,$champ){
	include_spip('inc/filtres');

	$string_objet=substr($objet,0,strlen($objet)-1);

	if($objet=='articles'){
		$where=array(
			'id_'.$string_objet.'='.$id_objet,
			'lang="'._request('lang').'"'		
			);
		}
	else{
		$where=array(
			'id_'.$string_objet.'='.$id_objet,	
			);	
		}
	$titre=sql_fetsel($champ,'spip_'.$objet,$where);
	
	$traduction_champ = extraire_multi(supprimer_numero($titre[$champ]));
	

	return $traduction_champ;

}

/* Fonction qui founit le lien */
function url_objet($id_objet,$objet){

	$title=info_objet($id_objet,$objet,'titre');

	$string_objet=substr($objet,0,strlen($objet)-1);

	$url=generer_url_entite($id_objet,$string_objet);
	
	$lien = '<a href="'.$url.'" title="'.$title.'">'.$title.'</a>';
	return $lien;
}



?>
