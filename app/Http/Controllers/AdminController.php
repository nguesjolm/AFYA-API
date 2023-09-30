<?php

namespace App\Http\Controllers;
use App\Models\Patient;
use App\Models\Pharmacy;
use App\Models\Livreur;
use App\Models\User;
use App\Models\ZoneSupervision;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;

class AdminController extends Controller
{

/**
 * -------
 * Patient
 * -------
 */
//affichage des comptes patient
function getallpatients(Request $request)
    {

        try {

            
            $compt= Patient::all();

            //verification 
            if(count($compt)==0){
                return response()->json([
                    "statuscode"=>400,
                    "status"=>false,
                    "message"=>"aucun compte trouvé",
                    
                ],400);
            }else{
                return response()->json([
                    "statuscode"=>200,
                    "status"=>true,
                    "message"=>"affichage des compte patient avec succes",
                    "compt"=>$compt
                ],200); 
            }
    
           }
            catch (\Throwable $th) {
            return response()->json([
                "statuscode"=>500,
                "status"=>true,
                "message"=>$th->getMessage()
            ],500); 
        } 
 }
//afficher un seul patient
 function getonepatient(Request $request)
 {
     try {
             $PatientId=Patient::firstwhere("id",$request->id);
             return response()->json([
                 "statusCode"=>200,
                 "status"=>true,
                 "message"=>" affichage effectué",
                 "ordonnance"=> $PatientId
             ],200);
         } catch (\Throwable $th) {
             //throw $th;
             return response()->json([
                 "statusCode"=>500,
                 "status"=>False,
                 "message"=>$th->getMessage()
             ],500);
         }
     
     
 }
        
// Modification des information du patient par l'admin

function updateonepatient(Request $request)
{
        
    try {
         //validation des données
         $id = $request->id;
         $nom = $request->nom;
         $prenom= $request->prenom;
    
     // procede a la modification des informations dans la base de données
     $updatePat=Patient::where("id",$id)->update(["id"=>$id,"nom"=> $nom,"prenom"=>$prenom]);
    
     //verification
     if($updatePat==0){
         return response()->json([
             "statusCode"=>401,
             "status"=>false,
             "message"=>"aucune modification effectué"
         ],401);
     }
     else{
         return response()->json([
             "statusCode"=>200,
             "status"=>True,
             "message"=>" modification effectué avec succes",
             "patient"=>$updatePat
         ],200);
     }
    
       } catch (\Throwable $th) {
        return response()->json([
            "statusCode"=>500,
            "status"=>false,
            "message"=>$th->getMessage()   
        ],500);
       }
}

/**
 * ---------
 * Pharmacie
 * ---------
 */

// ajout d'une pharmacie par l'admin

function ajouterunepharmacie(Request $request){
    try {
        // la validation des données

        //validation du nom de la zone de supervision
        $validateSup= validator::make($request->all(),[
            "zone_supervisions_id"=> 'required'
        ]);
        if($validateSup->fails()){
            return response()->json([
                "statuscode"=>401,
                "status"=>false,
                "message"=>"veillez saisir l'id de la zone",
                'errors' => $validateSup->errors()
            ],401);
          
        }
        //validation du nom de la pharmacy
        $validateNom= validator::make($request->all(),[
            "nom"=> 'required'
        ]);
        if($validateNom->fails()){
            return response()->json([
                "statuscode"=>401,
                "status"=>false,
                "message"=>"veillez saisir votre nom",
                'errors' => $validateNom->errors()
            ],401);
          
        }
        //validation du contact
        $validateCont= validator::make($request->all(),[
            "telephone"=> 'required'
        ]);
        if($validateCont->fails()){
            return response()->json([
                "statuscode"=>401,
                "status"=>false,
                "message"=>"veillez saisir votre contact",
                'errors' => $validateCont->errors()
            ],401);
          
        }
        //validation du mail
        $validateMail= validator::make($request->all(),[
            "Email"=> 'required'
        ]);
        if($validateMail->fails()){
            return response()->json([
                "statuscode"=>401,
                "status"=>false,
                "message"=>"veillez saisir votre email",
                'errors' => $validateMail->errors()
            ],401);
          
        }

        //validation de la ville
        $validateVil= validator::make($request->all(),[
            "ville"=> 'required'
        ]);
        if($validateVil->fails()){
            return response()->json([
                "statuscode"=>401,
                "status"=>false,
                "message"=>"veillez saisir votre email",
                'errors' => $validateVil->errors()
            ],401);
          
        }            

        //validation de la commune ou quartier
        $validateCq= validator::make($request->all(),[
            "commune_quartier"=> 'required'
        ]);
        if($validateCq->fails()){
            return response()->json([
                "statuscode"=>401,
                "status"=>false,
                "message"=>"veillez saisir votre commune ou quartier",
                'errors' => $validateCq->errors()
            ],401);
          
        }
        //validation de la localisation
        $validateLoc= validator::make($request->all(),[
            "localisation"=> 'required'
        ]);
        if($validateLoc->fails()){
            return response()->json([
                "statuscode"=>401,
                "status"=>false,
                "message"=>"veillez saisir votre Localisation",
                'errors' => $validateLoc->errors()
            ],401);
          
        }

        //validation Garde
        $validateGard= validator::make($request->all(),[
            "garde"=> 'required'
        ]);
        if($validateGard->fails()){
            return response()->json([
                "statuscode"=>401,
                "status"=>false,
                "message"=>"veillez saisir votre status",
                'errors' => $validateGard->errors()
            ],401);
          
        }

        //validation de la longitude
        $validateLong= validator::make($request->all(),[
            "longitude"=> 'required'
        ]);
        if($validateLong->fails()){
            return response()->json([
                "statuscode"=>401,
                "status"=>false,
                "message"=>"veillez saisir votre email",
                'errors' => $validateLong->errors()
            ],401);
          
        }

        //validation de la largitude
        $validateLarg= validator::make($request->all(),[
            "latitude"=> 'required'
        ]);
        if($validateLarg->fails()){
            return response()->json([
                "statuscode"=>401,
                "status"=>false,
                "message"=>"veillez saisir votre email",
                'errors' => $validateLarg->errors()
            ],401);
          
        }

        //validation de l'id user
        $validateUser= validator::make($request->all(),[
            "id_users"=> 'required'
        ]);
        if($validateUser->fails()){
            return response()->json([
                "statuscode"=>401,
                "status"=>false,
                "message"=>"veillez saisir votre email",
                'errors' => $validateUser->errors()
            ],401);
          
        }

        // creation de compte pharmacy

        $user=User::create([
            'phone' => $request->telephone,
        ]);

        $Pharmacy=Pharmacy::create([

            
            //'zone_supervisions_id' =>$request->zone_supervisions_id,
            'nom'                  =>$request->nom,
            'contacts'             =>$request->contacts,
            'Email'                =>$request->Email,
            'ville'                =>$request->ville,
            'commune_quartier'     =>$request->commune_quartier,
            'localisation'         =>$request->localisation,
            'garde'                =>$request->garde,
            'longitude'            =>$request->longitude,
            'latitude'             =>$request->latitude,
            //'id_users'             =>$request->id_users,
        ]);

        //generation de token

        return response()->json([
            "statusCode"=>200,
            "status"    =>True,
            "Message"   =>"votre compte est ouvert avec success",
            "livreur"   =>$Pharmacy,
            'token'     => $user->createToken("API TOKEN")->plainTextToken

        ],200);


    } catch (\Throwable $th) {
        
        //throw $th;
        return response()->json([
            "statusCode"=>500,
            "status"=>false,
            "message"=>$th->getMessage()
        ],500);
    }
 }

// afficher les modification apportée par l'admin sur une pharmacie

function updateonepharmacie(Request $request){
    try {
        // requete
        $id=$request->id;
        $nom=$request->garde;

        $updatePharma=Pharmacy::where('id',$id)->update(["id"=>$id,"garde"=>$nom]);
        if($updatePharma==0){
            return response()->json([
            "statusCode"=>400,
            "status" =>false,
            "message"=>"aucune modification patient effectué"
                ],400);
                }else{
                    return response()->json([
                        "statusCode"=>200,
                        "status" =>true,
                        "message"=> "modification patient effectué avec succes",
                        "user"=>$updatePharma
                    ],200); 
                }

    } catch (\Throwable $th) {
        //throw $th;
        return response()->json([
            "statusCode"=>500,
            "status" =>false,
            "message"=>$th->getMessage()
        ],500);
    }
}

 /**
     * -------
     * compte
     * -------
*/
    
 // afficher tous les comptes de la pharmacie
 function getallpharmacie(Request $request){
    try {
       
        $pharma=Pharmacy::all();
        if(count($pharma)!==0){
            return response()->json([
                "statusCode"=>200,
                "status"=>True,
                "message"=>"afficher les comptes",
                'ordonnance'   => $pharma
            ],200);
        }else{
            return response()->json([
                "statusCode"=>400,
                "status"=>False,
                "message"=>"aucun compte n'est trouvé"
            ],400);
        }

    } catch (\Throwable $th) {
        //throw $th;
        return response()->json([
            "statusCode"=>500,
            "status"=>False,
            "message"=>$th->getMessage()
        ],500);
    }
}

// affichage d'un seul  compte de la pharmacie par l'admin

function getonepharmacie(Request $request)
{
    try {
            $pharma=Pharmacy::firstwhere("id",$request->id);
            return response()->json([
                "statusCode"=>200,
                "status"=>true,
                "message"=>"affichage d'un compte  effectué",
                "ordonnance"=> $pharma
            ],200);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                "statusCode"=>500,
                "status"=>False,
                "message"=>$th->getMessage()
            ],500);
        }  
}

 // afficher les pharmacy avec leur status
 function getallpharmaciebystatus(Request $request)
 {
     try {
             $StatusPharma=Pharmacy::firstwhere("garde",$request->garde);
             return response()->json([
                 "statusCode"=>200,
                 "status"=>true,
                 "message"=>"pharmacie status effectué",
                 "ordonnance"=>$StatusPharma
             ],200);
         } catch (\Throwable $th) {
             //throw $th;
             return response()->json([
                 "statusCode"=>500,
                 "status"=>False,
                 "message"=>$th->getMessage()
             ],500);
         }    
 }

 // modification du status de la pharmacie par l'admin
 function updatepharmaciestatus(Request $request){
    try {
        //modification
        $id= $request->id;
        $garde= $request->garde;
        $updateStatePharma=Pharmacy::where("id",$id)->update(["id"=>$id,"payement"=>$garde]);
        if($updateStatePharma==0){
            return response()->json([
                "statusCode"=>400,
                "status"=>False,
                "message"=>"aucune ordonnance n'est trouvé"
            ],400);
        }else{
            return response()->json([
                "statusCode"=>200,
                "status"=>True,
                "message"=>"afficher les comptes",
                'ordonnance'   => $updateStatePharma
            ],200);
        }

    } catch (\Throwable $th) {
        //throw $th;
        return response()->json([
            "statusCode"=>500,
            "status"=>False,
            "message"=>$th->getMessage()
        ],500);
    }
 }
  // affichage de la zone de pharmmacie par l' admin

  function getallpharmaciebyzone(Request $request)
  {
      try {
              $ZonePharma=Pharmacy::firstwhere("zone_supervisions_id",$request->zone_supervisions_id);
              return response()->json([
                  "statusCode"=>200,
                  "status"=>true,
                  "message"=>"ordonnance id effectué",
                  "ordonnance"=> $ZonePharma
              ],200);
          } catch (\Throwable $th) {
              //throw $th;
              return response()->json([
                  "statusCode"=>500,
                  "status"=>False,
                  "message"=>$th->getMessage()
              ],500);
          }  
  }



/**
 * ---------------
 * LIVREUR (ADMIN)
 * ---------------
 */


 function ajouerunlivreur(Request $request)
 {
     /**
      * ----------------
      * AUTHENTIFICATION 
      * ----------------
      **/

     // inscription du livreur
     try {
         //validation des données


         //nom du livreur
         $validateNom= validator::make($request->all(), 
         [
             'nom' => 'required|min:3'
         ]);
         if( $validateNom->fails()){
             return response()->json([
                 "statuscode"=>401,
                 "status"=>false,
                 "message"=>"veillez saisir votre nom",
                 'errors' => $validateNom->errors()
             ],401);
         }
         //prenom du livreur
         $validatePren= validator::make($request->all(), 
         [
             'prenom' => 'required|min:3'
         ]);
         if( $validatePren->fails()){
             return response()->json([
                 "statuscode"=>401,
                 "status"=>false,
                 "message"=>"veillez saisir votre prenom",
                 'errors' => $validatePren->errors()
             ],401);
         }
         //date de naissance du livreur
         $validate_date= validator::make($request->all(), 
         [
             'date_naissance' => 'required'
         ]);
         if( $validate_date->fails()){
             return response()->json([
                 "statuscode"=>401,
                 "status"=>false,
                 "message"=>"veillez saisir votre date de naissance",
                 'errors' => $validatePren->errors()
             ],401);
         }
         //telephone du livreur
         $validate_Tel= validator::make($request->all(), 
         [
             'telephone' => 'required'
         ]);
         if( $validate_Tel->fails()){
             return response()->json([
                 "statuscode"=>401,
                 "status"=>false,
                 "message"=>"veillez saisir votre telephone",
                 'errors' => $validate_Tel->errors()
             ],401);
         }
         //CNI du livreur
         $validate_cni= validator::make($request->all(), 
         [
             'cni' => 'required'
         ]);
         if( $validate_cni->fails()){
             return response()->json([
                 "statuscode"=>401,
                 "status"=>false,
                 "message"=>"veillez saisir votre numero cni",
                 'errors' => $validate_cni->errors()
             ],401);
         }
         //numero de telephone parent du livreur
         $validate_num= validator::make($request->all(), 
         [
             'telephone_parents' => 'required|min:10'
         ]);
         if( $validate_num->fails()){
             return response()->json([
                 "statuscode"=>401,
                 "status"=>false,
                 "message"=>"veillez saisir le numeros parent",
                 'errors' => $validate_num->errors()
             ],401);
         }
         //email du livreur
         $validate_email= validator::make($request->all(), 
         [
             'email' => 'required'
         ]);
         if( $validate_email->fails()){
             return response()->json([
                 "statuscode"=>401,
                 "status"=>false,
                 "message"=>"veillez saisir votre email",
                 'errors' => $validate_email->errors()
             ],401);
         }
         //nom du parent  du livreur
         $validate_parent= validator::make($request->all(), 
         [
             'nom_parent' => 'required'
         ]);
         if( $validate_email->fails()){
             return response()->json([
                 "statuscode"=>401,
                 "status"=>false,
                 "message"=>"veillez saisir le nom de votre parent",
                 'errors' => $validate_parent->errors()
             ],401);
         }
         //actif(status)  du livreur
         $validate_actif= validator::make($request->all(), 
         [
             'actif' => 'required'
         ]);
         if( $validate_actif->fails()){
             return response()->json([
                 "statuscode"=>401,
                 "status"=>false,
                 "message"=>"veillez saisir votre status",
                 'errors' => $validate_actif->errors()
             ],401);
         }
         // //user livreur
         // $validate_user= validator::make($request->all(), 
         // [
         //     'id_users' => 'required'
         // ]);
         // if( $validate_user->fails()){
         //     return response()->json([
         //         "statuscode"=>401,
         //         "status"=>false,
         //         "message"=>"veillez saisir votre status",
         //         'errors' => $validate_user->errors()
         //     ],401);
         // }
         //fin de la validation
         
         // ouverture du compte

         $user= User::create([
             'phone' => $request->telephone,
         ]);

         $livreur= Livreur::create([

             'nom'                 =>$request->nom,
             'prenom'              =>$request->prenom,
             'date_naissance'      =>$request->date_naissance,
             'telephone'           =>$request->telephone,
             'cni'                 =>$request->cni,
             'telephone_parents'   =>$request->telephone_parents,
             'email'               =>$request->email,
             'nom_parent'          =>$request->nom_parent,
             'actif'               =>$request->actif,
             'id_users'            =>$user->id,
         ]);

         //generation de token

         return response()->json([
             "statusCode"=>200,
             "status"    =>True,
             "Message"   =>"votre compte est ouvert avec success",
             "livreur"   =>$livreur,
             'token'     => $user->createToken("API TOKEN")->plainTextToken

         ],200);


     } catch (\Throwable $th) {
         //throw $th;
         return response()->json([
             "statusCode"=>500,
             "status"=>false,
             "message"=>$th->getMessage()
         ],500);
     }
 }


//afficher les livreur avec leur id par l'admin
function getonelivreurbyid(Request $request)
{
    try {
            $Livr=Livreur::firstwhere("id",$request->id);
            return response()->json([
                "statusCode"=>200,
                "status"=>true,
                "message"=>" le compte livreur effectué",
                "ordonnance"=> $Livr
            ],200);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                "statusCode"=>500,
                "status"=>False,
                "message"=>$th->getMessage()
            ],500);
        }
    
    
}
// modification des information du Livreur par l'admin

function updateonelivreur (Request $request){
    
    try 
    {
        // validation des données
        $id= $request->id;
        $nom= $request->nom;
                
        //$user=User::all();
    
        //modification des données
        $updateLivr=Livreur::where('id',$id)->update(['id'=>$id,'nom'=>$nom]);
        if($updateLivr==0){
            return response()->json([
            "statusCode"=>400,
            "status" =>false,
            "message"=>"aucune modification patient effectué"
                ],400);
                }else{
                    return response()->json([
                        "statusCode"=>200,
                        "status" =>true,
                        "message"=> "modification Livreur effectué avec succes",
                        "user"=>$updateLivr
                    ],200); 
                }
    
    } catch (\Throwable $th) {
                    //throw $th;
                    return response()->json([
                        "statusCode"=>500,
                        "status" =>false,
                        "message"=>$th->getMessage()
                    ],500); 
                }

}


  //aficher tous compte des Livreur par l'admin 

  function getalllivreur(Request $request){
    try {
        $afLivr= Livreur::all();

        if(count($afLivr)!==0){
            return response()->json([
                "statuscode"=>200,
                "status"=>True,
                "Message"=>"compte afficher avec succes",
                "compte"=>$afLivr
            ],200);
        }else{
            return response()->json([
                "statuscode"=>404,
                "status"=>false,
                "Message"=>"aucun compte " 
            ],404);  
        }

    } catch (\Throwable $th) {
        //throw $th;
        return response()->json([
            "statuscode"=>500,
            "status"=>false,
            "Message"=>$th->getMessage()
        ],500);
    }
}


//afficher les Livreur avec leur  status
function getalllivreurbystatus(Request $request)
{
    try {
            $stateLivr=Livreur::firstwhere("actif",$request->actif);
            return response()->json([
                "statusCode"=>200,
                "status"=>true,
                "message"=>" status du livreur effectué",
                "Livreur"=> $stateLivr
            ],200);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                "statusCode"=>500,
                "status"=>False,
                "message"=>$th->getMessage()
            ],500);
        }
    
    
}

/**
 * -------------------
 * ZONE DE SUPERVISION
 * -------------------
 */

function ajouterunezone(Request $request){
    try {
        //vallidation des donnéés

        $validateSup_Id=validator::make($request->all(),[
            "superviseurs_id"=>"required"
        ]);
        if($validateSup_Id->fails()){
            return response()->json([
                "statuscode"=>401,
                "status"=>false,
                "message"=>"veillez saisir votre status",
                'errors' => $validateSup_Id->errors()
            ]);
        }

        // validation de la ville
        $validateVil=validator::make($request->all(),[
            "ville"=>"required"
        ]);
        if($validateVil->fails()){
            return response()->json([
                "statuscode"=>401,
                "status"=>false,
                "message"=>"veillez saisir votre status",
                'errors' => $validateVil->errors()
            ]);
        }
        // validation de la commune_quartier
        $validateCq=validator::make($request->all(),[
            "commune_quartier"=>"required"
        ]);
        if($validateCq->fails()){
            return response()->json([
                "statuscode"=>401,
                "status"=>false,
                "message"=>"veillez saisir votre status",
                'errors' => $validateCq->errors()
            ]);
        }
        // validation du code
        $validateCod=validator::make($request->all(),[
            "commune_quartier"=>"required"
        ]);
        if($validateCod->fails()){
            return response()->json([
                "statuscode"=>401,
                "status"=>false,
                "message"=>"veillez saisir votre status",
                'errors' => $validateCod->errors()
            ]);
        }
    // creation de la zone de supervison 
    $zon=ZoneSupervision::create([
        "superviseurs_id"   =>$request->superviseurs_id,
		"ville"             =>$request->superviseurs_id,
		"commune_quartier"  =>$request->superviseurs_id,
		"code"              =>$request->superviseurs_id
    ]);

    //generation de token
                    return response()->json([
                    "statusCode"=>200,
                    "status"    =>True,
                    "Message"   =>"votre compte est ouvert avec success",
                    "livreur"   =>$zon,
                    //'token'     => $user->createToken("API TOKEN")->plainTextToken
    
                ],200);

    } catch (\Throwable $th) {
        //throw $th;
        return response()->json([
            "statusCode"=>500,
            "status"=>false,
            "message"=>$th->getMessage()
        ],500);
    }
}

//afficher les Zone de supervision avec leur id
function getonezonebyid(Request $request)
{
    try {
            $Zon=ZoneSupervision::firstwhere("id",$request->id);
            return response()->json([
                "statusCode"=>200,
                "status"=>true,
                "message"=>"ordonnance id effectué",
                "Zonz de supervision"=> $Zon
            ],200);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                "statusCode"=>500,
                "status"=>False,
                "message"=>$th->getMessage()
            ],500);
        }
    
    
}

 //afficher toute les zone de supervision
 function getallzone(Request $request){

        
    try {

        $ZonSup= ZoneSupervision::all();
        if(count($ZonSup)!==0){
            return response()->json([
                "statusCode"=>200,
                "status"=>True,
                "message"=>"afficher les comptes",
                'ordonnance'   => $ZonSup
            ],200);
        }else{
            return response()->json([
                "statusCode"=>400,
                "status"=>False,
                "message"=>"aucun compte n'est trouvé"
            ],400);
        }
            }
        catch (\Throwable $th)
        {
        return response()->json([
            "statusCode"=>500,
            "status"=>False,
            "message"=>$th->getMessage()
        ],500);
        }


}

// modification des information de la zone de supervision

function updateonzone (Request $request){
    
    try 
    {
        // validation des données
        $id= $request->id;
        $ville= $request->vile;
                
        //$user=User::all();
    
        //modification des données
        $updateZon=ZoneSupervision::where('id',$id)->update(['id'=>$id,'nom'=>$ville]);
        if($updateZon==0){
            return response()->json([
            "statusCode"=>400,
            "status" =>false,
            "message"=>"aucune modification patient effectué"
                ],400);
                }else{
                    return response()->json([
                        "statusCode"=>200,
                        "status" =>true,
                        "message"=> "modification patient effectué avec succes",
                        "user"=>$updateZon
                    ],200); 
                }
    
    } catch (\Throwable $th) {
                    //throw $th;
                    return response()->json([
                        "statusCode"=>500,
                        "status" =>false,
                        "message"=>$th->getMessage()
                    ],500); 
                }

}

}
