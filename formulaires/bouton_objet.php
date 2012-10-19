<?php

if (!defined("_ECRIRE_INC_VERSION")) return;

function verifier_ordre($where){
	$result_num = sql_select("*","spip_selection_objets", $where,'', "ordre,id_objet");
	$ordre = 0;
				
	// on vérifie l'ordre des objets déjà enregistrés et on corrige si besoin
				
	while ($row = sql_fetch($result_num)) {
		$ordre++;
		$where = array(
			'id_objet='.$row['id_objet'],					
			'id_objet_dest='.$row['id_objet_dest'],
			'objet_dest="'.$row['objet_dest'].'"',
			'lang="'.$row['lang'].'"',	
			);

		sql_updateq("spip_selection_objets",array("ordre" => $ordre),$where) ;
		}
		
	return $ordre;
}

function formulaires_bouton_objet_charger_dist($id_objet,$objet,$langue,$lang='',$objet_dest='rubrique',$id_objet_dest) {
    
    $valeurs = array(
	"id_objet"	=> $id_objet,
	"objet"	=> $objet,	
	"langue"	=> $langue,	
	"objet_dest"=>$objet_dest,
    "id_objet_dest"=>$id_objet_dest,		 		
    );
    $valeurs['_hidden'] .= "<input type='hidden' name='id_objet' value='$id_objet' />";
    $valeurs['_hidden'] .= "<input type='hidden' name='objet' value='$objet' />";
    $valeurs['_hidden'] .= "<input type='hidden' name='lang' value='$langue' />";
    $valeurs['_hidden'] .= "<input type='hidden' name='objet_dest' value='$objet_dest' />";

    
    $where=array(
    	'id_objet='.$id_objet,
       	'objet='.sql_quote($objet), 		
    	);
    	
	if($id_objet_dest){
		$where['id_objet_dest'] =_request('id_objet_dest');
		$where['objet_dest'] =_request('objet_dest');					
		}
		
	if($lang)$where[2]='lang='.sql_quote($lang);	
	
        
   	$l= sql_getfetsel('lang','spip_selection_objets',$where);
   	
	$langues=explode(',',$langue);
	

	if(in_array($l,$langues))$valeurs['selectionne']='ok';

    return $valeurs;
}



/* @annotation: Actualisation de la base de donnée */
function formulaires_bouton_objet_traiter_dist($id_objet,$objet,$langue,$lang=''){
	$id_objet_dest=_request('id_objet_dest');
	$objet_dest=_request('objet_dest');
    $valeurs='';
	
	if(!$id_objet_dest){
		$id_objet_dest ='0';
		$objet_dest ='-';				
		}

	if($langue)$langue=explode(',',$langue);
	else $langue=array();


		// si objet pas définit par langue on enrgistre pour chaque langue du site
		if(count($langue)>1){
		
			foreach ($langue as $key => $l){
						
				$where = array(
					'id_objet_dest='.$id_objet_dest,
					'objet_dest="'.$objet_dest.'"',
					'lang="'.$l.'"',	
					);
		
				$ordre=verifier_ordre($where);
					
				// on rajoute comme dernier le nouveau objet	
				$ordre=$ordre+1;
			
				$valeurs=array(
					'id_objet' => $id_objet,
					'objet'=>$objet, 
					'id_objet_dest'=>$id_objet_dest,
					'objet_dest'=>$objet_dest,			 	
					'ordre'=>$ordre, 
					'lang'=>$l
					);
					
				sql_insertq("spip_selection_objets",$valeurs);
				}

			}
		// si objet est définit par langue on enregistre pour cette langue	
		else{
			$where = array(
				'id_objet_dest='.$id_objet_dest,
				'objet_dest="'.$objet_dest.'"',
				'lang="'.$langue[0].'"',	
				);
			// on vérifie l'ordre des objets déjà enregistrés et on corrige si besoin
			
			$ordre=verifier_ordre($where);
				
			// on rajoute comme dernier le nouveau objet			
			$ordre=$ordre+1;
			
			$valeurs=array(
				'id_objet' => $id_objet,
				'objet'=>$objet, 
				'id_objet_dest'=>$id_objet_dest,
				'objet_dest'=>$objet_dest,			 	
				'ordre'=>$ordre, 
				'lang'=>$langue[0]
				);
					
			sql_insertq("spip_selection_objets",$valeurs);
		
			}
			
			
			

return $valeurs;
	
}
?>
