<?php

function so_affiche_gauche($flux) {
   $exec = $flux["args"]["exec"];

   
      $contexte = array();
      
   	switch($exec){
   	case  'article':
   		$contexte['objet']='article';
    	$contexte['id_objet']=$flux["args"]["id_article"]; 
    		
    	$sql = sql_fetsel('lang','spip_articles','id_article='.$contexte['id_objet']);

		$contexte['langue'] = $sql['lang'];	
		$contexte['lang'] = $contexte['langue'];			
			
    		 				
   		break;
   		
   	case  'rubrique':
		include_spip('inc/config');
    	$contexte['objet']='rubrique';

    	$contexte['id_objet']=$flux["args"]["id_rubrique"]; 
    		  		
   		$sql = sql_fetsel('langue_choisie,lang','spip_rubriques','id_rubrique='.$contexte['id_objet']);
   		
   		$contexte['langue'] = $sql['lang'];
   		
		if (!$trad_rub=test_plugin_actif('tradrub')) $contexte['langue']=lire_config('langues_multilingue');
		else $contexte['lang'] = $contexte['langue'];	
		
		
   		
   		/*if($sql['langue_choisie']!='non')$contexte['langue'] = $sql['lang'];
   		
   		if($sql['langue_choisie'] == 'non') $contexte['langue'] = explode(",",lire_config("langues_utilisees"));  */

   		break;   
   	}

	if ($contexte['objet']){
		
	

      $ret .= recuperer_fond("prive/gauche", $contexte);

      $flux["data"] .= $ret;
	};
    return $flux;
}

function so_affiche_milieu ($vars="") {
    $exec = $vars["args"]["exec"];
   
    $id_rubrique = $vars["args"]["id_rubrique"];
        if (!$id_rubrique)$id_rubrique=0;
        $id_article = $vars["args"]["id_article"];
        $data = $vars["data"];
        
        $active = picker_selected(lire_config('pb_selection/selection_rubrique'),'rubrique');
        
    
        if ($exec == "rubrique" && in_array($id_rubrique,$active) OR ($exec == "accueil" && in_array($id_rubrique,$active))) {

            include_spip("inc/utils");
    
            
            $contexte = array('id_objet_dest'=>$id_rubrique,'objet_dest'=>'rubrique');
    
            $ret .= "<div id='pave_selection'>";
        
            $page = recuperer_fond('prive/inclure/selection_interface', $contexte,array('ajax'=>'oui'));
            $ret .= $page["texte"];

            $ret .= "</div>";

        }


        $data .= $ret;
    
        $vars["data"] = $data;
        return $vars;
    }

?>
