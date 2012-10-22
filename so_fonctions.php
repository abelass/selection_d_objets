<?php


/* Fonction qui traduit les champs */
function info_objet($id_objet,$objet,$champ='*'){
	include_spip('inc/filtres');
    
    $where=array(
            'id_'.$objet.'='.$id_objet,  
            );  
        

	if($champ=='*')$data=sql_fetsel($champ,'spip_'.$objet.'s',$where);
    else $data=sql_getfetsel($champ,'spip_'.$objet.'s',$where);
	
    //Appliquer des filtres sur des champs spéciciques
    $filtres=array(
        'supprimer_numero'=>array(
        'titre','nom'
        )
       );
        
    foreach($filtres as $filtre => $champ){
        if(is_array($data) AND $data[$champ]) $data[$champ]=$filtre($data[$champ]);
        else $data=$filtre($data);
        }
	return $data;

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
