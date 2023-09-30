<?php

namespace App\Http\Controllers;
use App\Models\Livreur;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Ordonnance;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class LivreurController extends Controller
{
    function inscriptionlivreur(Request $request)
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

    // connexion du livreur

    function loginLivreur(Request $request){
        try {
            // validation des données
             $validateLogin= validator::make($request->all(),[
                "telephone"=>"required",
             ]);

             if($validateLogin->fails()){
                return response()->json([
                    'statusCode' => 401,
                    'status' => false,
                    'message' => 'Numero de téléphone obligatoire',
                    'errors' => $validateLogin->errors()
                ], 401);
            }
            #Vérifier les données de connection
            $Livreur = Livreur::firstWhere('telephone',$request->telephone);
            if ($Livreur) {
                $user = User::firstWhere('phone', $request->telephone)->first();
                return response()->json([
                    "statuscode"=>200,
                    "status"    =>true,
                    "message"   =>"connecté avec succès",
                    "patient"   =>$Livreur,
                    "token"     =>$user->createToken("API TOKEN")->plainTextToken
                 ],200);
            }else{
                return response()->json
                ([
                    "statuscode"=>401,
                    "status"=>false,
                    "message"=>" telephone incorrecte",
                    "livreur"=>[],
                 ],401);
            }
            

        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'statusCode' => 500,
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }



/**
 * --------
 * compte
 * --------
 */

  //aficher le compte des patients

  function getLivreurCount(Request $request){
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

// modification des information du Livreur

function updateLivreurCount (Request $request){
    
        try 
        {
            // validation des données
            $id= $request->id;
            $nom= $request->nom;
                    
            //$user=User::all();
        
            //modification des données
            $update=Livreur::where('id',$id)->update(['id'=>$id,'nom'=>$nom]);
            if($update==0){
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
                            "user"=>$update
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
 *-----------
 *ORDONNANCE
 * ----------
 */

 //afficher toute les ordonnances
function getallordonnance(Request $request){

        
        try {
            //$user=User::all();
            //affichage des ordonnances 
            $ordonnance= Ordonnance::all();
            if(count($ordonnance)!==0){
                return response()->json([
                    "statusCode"=>200,
                    "status"=>True,
                    "message"=>"afficher les comptes",
                    'ordonnance'   => $ordonnance
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


// afficher les ordonnance avec leur status
function getordonnancebystatus(Request $request)
{
    try {
            $StatusOrd=Ordonnance::firstwhere("payement",$request->payement);
            return response()->json([
                "statusCode"=>200,
                "status"=>true,
                "message"=>"ordonnance status effectué",
                "ordonnance"=>$StatusOrd
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

//afficher les ordonnance avec leur id
function getordonnancebyid(Request $request)
{
    try {
            $idordonnance=Ordonnance::firstwhere("id",$request->id);
            return response()->json([
                "statusCode"=>200,
                "status"=>true,
                "message"=>"ordonnance id effectué",
                "ordonnance"=> $idordonnance
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
    






}