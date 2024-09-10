<?php

use App\Models\User;
use App\Models\Valeur;
use App\Models\Recette;
use App\Models\Tache;
use App\Models\FormulaireRecu;
use Carbon\Carbon;
Use App\Models\RecetteQuittance;
Use App\Models\Formulaire;

if (!function_exists('getlibelle')) {
    function getlibelle($id)
        {
            $record = Valeur::where('id', $id)->first();
            $libelle = isset($record['libelle']) ? $record['libelle'] : "";
                return $libelle;
        }
    }

    if (!function_exists('reformater_montant2')){
        function reformater_montant2($money){
            $$money = str_replace('F CFA', '', strval($money));
            $cleanString = preg_replace('/([^0-9\.,])/i', '', $money);
            $onlyNumbersString = preg_replace('/([^0-9])/i', '', $money);
            $separatorsCountToBeErased = strlen($cleanString) - strlen($onlyNumbersString) - 1;
            $stringWithCommaOrDot = preg_replace('/([,\.])/', '', $cleanString, $separatorsCountToBeErased);
            $removedThousandSeparator = preg_replace('/(\.|,)(?=[0-9]{3,}$)/', '',  $stringWithCommaOrDot);
            return (int) str_replace(',', '.', $removedThousandSeparator);
        }
    }
    if (!function_exists('getrepresentationmembre')) {
        function getrepresentationmembre($id)
            {
                $record = User::where('id', $id)->first();
                $structure_represente = isset($record['structure_represente']) ? $record['structure_represente'] : "";
                return getlibelle($structure_represente) ;
            }
        }
        if(!function_exists('format_prix')){
            function format_prix($prix){
                return number_format($prix, 0, ' ',' ');
            }
        }
        if(!function_exists('format_date')){
            function format_date($date){
                return  date('d-m-Y', strtotime($date));
            }
           
        }
        if(!function_exists('reformat_date')){
            function reformat_date($date){
                return  date('y-m-d', strtotime($date));
            }
           
        }
        if(!function_exists('calculer_age')){
            function calculer_age($date){
                $date =strtotime($date);
                    $age = date('Y') - $date;
                   if (date('md') < date('md', strtotime($date))) {
                       return $age - 1;
                   }
                   return $age;
            }
        }

        if(!function_exists('file')){
            function file($champName){
                $file=$request->hasFile($champName);
                $emplacement='public/'.$champName;
                $extension=$file->getClientOriginalExtension();
                $fileName = $projet->personne_id.'-'.$champName.'.'.$extension;
                $file_url= $request[$champName]->storeAs($emplacement, $fileName); 
                return $file_url;
            }
            
        }
        

        if(!function_exists('return_region_infos')){

            function return_region_infos($region_id){
                $startOfYear = Carbon::now()->startOfYear();
                // Récupérer la date de la fin de l'année en cours
                $endOfYear = Carbon::now()->endOfYear();
                $ctids= Valeur::find($region_id)->ctids;
                $detail_region=[];
                $ctid_ids=[];
            if($ctids){
                foreach($ctids as $ctid){
                    $ctid_ids[]=$ctid->id;
                    }
                    $formulaires= Formulaire::whereIn('centre_traitement_id',$ctid_ids)->whereBetween('formulaires.date_fourniture', ['2024-01-01', '2024-12-31'])->get();
                    $recette_quittances= RecetteQuittance::whereIn('centre_traitement_id',$ctid_ids)->whereBetween('recette_quittances.created_at', [$startOfYear, $endOfYear])->get();
                    $formulaire_recu= FormulaireRecu::whereIn('centre_traitement_id',$ctid_ids)->whereBetween('formulaire_recus.created_at', [$startOfYear, $endOfYear])->get();
                    $restant = $formulaires->sum('nombre') - $formulaire_recu->sum('nbre_formulaire');
                    $detail_region= array('region'=>$region_id, 'montant_recette_quittance'=>$recette_quittances->sum('montant'), 'nombre_formulaire_emis'=>$formulaires->sum('nombre'), 'nombre_formulaire_saisies'=>$formulaire_recu->sum('nbre_formulaire') , 'nombre_formulaire_recette'=>$recette_quittances->sum('nbre_formulaire'),  'nbre_formulaire_rejete'=>$recette_quittances->sum('nbre_rejet') , 'nbre_formulaire_restant'=> $restant);
                }
                else{
                    $detail_region= array('region'=>null, 'montant_recette_quittance'=>null, 'nombre_formulaire_emis'=>null , 'nombre_formulaire_saisies'=>null , 'nbre_formulaire_rejete'=>null);
                }
               return $detail_region;
            }
            
        }
        if(!function_exists('return_nbre_quittance_recette')){
            function return_nbre_quittance_recette($formulaire_recu_id)
            {
               $nbre_quittance= RecetteQuittance::where('formulaire_recus_id', $formulaire_recu_id)->count();
               return $nbre_quittance;
            }
            
        }

        if(!function_exists('recette_is_validate')){
            function recette_is_validate($quittance_recette_id)
            {
               $recette_validate= Recette::where('quittance_recette_ass', $quittance_recette_id)->where('statut','!=',0)->count();
               if($recette_validate == 0){
                        return false;
               }else{
                return  true;
               }
              
            }
            
        }
        if(!function_exists('tache_en_retard')){
            function tache_en_retard($tache_id)
            {
                $today = Carbon::now();
               $tache= Tache::find($tache_id);
               if($tache->deadline < $today){
                        return true;
               }else{
                return  false;
               }
              
            }
            
        }
        if(!function_exists('return_role_adequat')){
            function return_role_adequat($id_role){
               $liste_roles= Auth::user()->roles;
                foreach($liste_roles as $role)
                {
                    if($role->id==$id_role){
                        return true;
                    }
                }
                    return false;
        
            }
        }

        if(!function_exists('get_month_french')){
            function get_month_french($mois){
                switch($mois){
                    case 1:
                        return 'Janvier';
                    break;
                    case 2:
                        return 'Février';
                    break;
                    case 3:
                        return 'Mars';
                    break;
                    case 4:
                        return 'Avril';
                    break;
                    case 5:
                        return 'Mai';
                    break;
                    case 6:
                        return 'Juin';
                    break;
                    case 7:
                        return 'Juillet';
                    break;
                    case 8:
                        return 'Aout';
                    break;
                    case 9:
                        return 'Septembre';
                    break;
                    case 10:
                        return 'Octobre';
                    break;
                    case 11:
                        return 'Novembre';
                    break;
                    case 12:
                        return 'Décembre';
                    break;

                }

            }
        }

        
?>
