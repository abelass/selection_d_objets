<?php

function so_affiche_gauche($flux) {
    include_spip('inc/config');
    
    $exec = $flux["args"]["exec"];
    $contexte=array();
    $objets=lire_config('so/selection_rubrique_objet',array());
    $args=$flux['args'];
    $objet_contexte=$args['exec'];
    $contexte['objet_dest']='rubrique';
    foreach($objets AS $objet){
        if($objet_contexte==$objet){
            $contexte['objet']=$objet;
            $contexte['id_objet']=$flux["args"]['id_'.$objet]?$flux["args"]['id_'.$objet]:_request('id_'.$objet); 
            $contexte['langue']=sql_getfetsel('lang','spip_'.$objet.'s','id_'.$objet.'='.$contexte['id_objet']);
            $contexte['lang'] = $contexte['langue'];
            if ($objet='rubrique' AND !$trad_rub=test_plugin_actif('tradrub')) $contexte['langue']=lire_config('langues_multilingue');
            $fond = recuperer_fond("prive/inclure/affiche_gauche", $contexte);
            $flux["data"] .= $fond;
            }
        }
      
    return $flux;
}

function so_affiche_milieu ($vars="") {
    $exec = $vars["args"]["exec"];
   
    $id_rubrique = $vars["args"]["id_rubrique"];
        if (!$id_rubrique)$id_rubrique=0;
        $id_article = $vars["args"]["id_article"];
        $data = $vars["data"];
        
        $active = picker_selected(lire_config('so/selection_rubrique'),'rubrique');
        

        
    
        if ($exec == "rubrique" && in_array($id_rubrique,$active) OR ($exec == "accueil" && in_array($id_rubrique,$active))) {
            include_spip("inc/utils");
            $contexte = array('id_objet_dest'=>$id_rubrique,'objet_dest'=>'rubrique');
            $ret .= "<div id='pave_selection'>";
            $page = recuperer_fond('prive/inclure/selection_interface', $contexte,array('ajax'=>'oui'));
            $ret .= $page;
            $ret .= "</div>";

        }

        $data .= $ret;
    
        $vars["data"] = $data;
        return $vars;
    }

?>
