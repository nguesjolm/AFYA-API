<?php

namespace App\Http\Controllers;
use App\Models\Pharmacy;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Ordonnance;
use App\Models\Facture;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class PharmacieController extends Controller
{
    /**
     * ----------------
     * AUTHENTIFICATION
     * ----------------
     */

     //l'inscription

     function inscriptionpharmacie(Request $request){
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

    //La connection au compte de la pharmacie

    function loginPharmacie(Request $request){
        try {
            //validation des 
           $validateLogin=validator::make($request->all(),[
                "telephone"=>"required"
           ]);
           if($validateLogin->fails()){
                return response()->json([
                    "statuscode"=>401,
                    "status"=>false,
                    "message"=>'Numero de téléphone et mot de passe obligatoire',
                    "error"=>$validateLogin->error()
                ],401);
           }

        // verification de la connexion  
        $Pharmacy = Pharmacy::firstWhere('telephone',$request->tel);
        if ($Pharmacy) {
            $user = User::firstWhere('phone', $request->telephone)->first();
            return response()->json([
                "statuscode"=>200,
                "status"    =>true,
                "message"   =>"connecté avec succès",
                "patient"   =>$Pharmacy,
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
        }
    }

    /**
     * -------
     * compte
     * -------
     */
    
 // afficher tous les comptes de la pharmacie
    function pharmacieCount(Request $request){
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

    function updatePharmacieCount(Request $request){
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
     * -----------
     * ORDONNANCE
     * -----------
     */

// afficher les ordonnance dans le compte de la pharmacie
function getPharmacieOrdon(Request $request){
    try {
       
        $ordonPharma=Ordonnance::all();
        if(count($ordonPharma)==0){
            return response()->json([
                "statusCode"=>400,
                "status"=>False,
                "message"=>"aucun compte n'est trouvé"
            ],400);
        }
        else{
            return response()->json([
                "statusCode"=>200,
                "status"=>True,
                "message"=>"afficher les comptes",
                'ordonnance'   => $ordonPharma
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

 // afficher les ordonnance avec leur status
function getPharmacieOrdonStatus(Request $request)
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

 // modification du status de l'ordonnance dans le compte de la pharmacie
 function updatePharmacieOrdonStatus(Request $request){
    try {
        //modification
        $id= $request->id;
        $delivery_state= $request->delivery_state;
        $updateState=Ordonnance::where("id",$id)->update(["id"=>$id,"payement"=>$delivery_state]);
        if($updateState==0){
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
                'ordonnance'   => $updateState
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
 // affichage de l'ordonnance par id dans le compte de la pharmacie

 function getPharmacieOrdonId(Request $request)
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

    /**
     * -----------
     *   FACTURE
     * -----------
     */


    function sendFacture(Request $request){
        try {
            //validation des donnees

            // id du patient (Facture)
            $validatePat=validator::make($request->all(),[
                "patients_id"=>"required"
            ]);
            if($validatePat->fails()){
                return response()->json([
                    "statuscode"=>401,
                    "status"=>false,
                    "message"=>"veillez saisir id du patient",
                    'errors' => $validatePat->errors()
                ],401);
            }
            
            // id du Pharmacie (Facture)
            $validatePharma=validator::make($request->all(),[
                "pharmacies_id"=>"required"
            ]);
            if($validatePharma->fails()){
                return response()->json([
                    "statuscode"=>401,
                    "status"=>false,
                    "message"=>"veillez saisir id de la pharmacie",
                    'errors' => $validatePharma->errors()
                ],401);
            }

            // id de ordonnance (Facture)
            $validateOrdon=validator::make($request->all(),[
                "ordonnances_id"=>"required"
            ]);
            if($validateOrdon->fails()){
                return response()->json([
                    "statuscode"=>401,
                    "status"=>false,
                    "message"=>"veillez saisir l' id de l'ordonnance",
                    'errors' => $validateOrdon->errors()
                ],401);
            }

            // Le numero de la facture (Facture)
            $validateFact=validator::make($request->all(),[
                "numero_facture"=>"required"
            ]);
            if($validateFact->fails()){
                return response()->json([
                    "statuscode"=>401,
                    "status"=>false,
                    "message"=>"veillez saisir le numero de la facture",
                    'errors' => $validateFact->errors()
                ],401);
            }

            // le prix de la (Facture)
            $validatePrix=validator::make($request->all(),[
                "prix"=>"required"
            ]);
            if($validatePrix->fails()){
                return response()->json([
                    "statuscode"=>401,
                    "status"=>false,
                    "message"=>"veillez saisir le prix",
                    'errors' => $validatePrix->errors()
                ],401);
            }

            // La description (Facture)
            $validateDescript=validator::make($request->all(),[
                "description"=>"required"
            ]);
            if($validateDescript->fails()){
                return response()->json([
                    "statuscode"=>401,
                    "status"=>false,
                    "message"=>"veillez saisir La description",
                    'errors' => $validateDescript->errors()
                ],401);
            }

            // Le montant (Facture)
            $validateMont=validator::make($request->all(),[
                "montant"=>"required"
            ]);
            if($validateMont->fails()){
                return response()->json([
                    "statuscode"=>401,
                    "status"=>false,
                    "message"=>"veillez saisir Le montant",
                    'errors' => $validateMont->errors()
                ],401);
            }

            // La date de la facture (Facture)
            $validateDate=validator::make($request->all(),[
                "date_facture"=>"required"
            ]);
            if($validateDate->fails()){
                return response()->json([
                    "statuscode"=>401,
                    "status"=>false,
                    "message"=>"veillez saisir la date",
                    'errors' => $validateDate->errors()
                ],401);
            }

            // payement (Facture)
            $validatePay=validator::make($request->all(),[
                "payement"=>"required"
            ]);
            if($validatePay->fails()){
                return response()->json([
                    "statuscode"=>401,
                    "status"=>false,
                    "message"=>"veillez saisir le status du payement",
                    'errors' => $validatePay->errors()
                ],401);
            }

            //creation de la facture
            // $user=User::create([
                //'phone' => $request->telephone,
            //]);

            $facture=Facture::create([
                'patients_id'       =>$request->patients_id,
                'pharmacies_id'     =>$request->pharmacies_id,
                'ordonnances_id'    =>$request->ordonnances_id,
                'numero_facture'    =>$request->numero_facture,
                'prix'              =>$request->prix,
                'description'       =>$request->description,
                'montant'           =>$request->montant,
                'date_facture'      =>$request->date_facture,
                'payement'          =>$request->payement
            ]);

            // generation de token
            return response()->json([
                "statusCode"=>200,
                "status"    =>True,
                "Message"   =>"votre compte est ouvert avec success",
                "Facture"   =>$facture,
                // 'token'     => $user->createToken("API TOKEN")->plainTextToken

            ],200);

        } catch (\Throwable $th) {
            return response()->json([
                'statusCode' => 500,
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }

    }

// (A REVOIR )

// afficher les factures

function getPharmcieFacture(Request $request){
    try {
        $fact= Facture::all();

        if(count($fact)!==0){
            return response()->json([
                "statuscode"=>200,
                "status"=>True,
                "Message"=>"compte afficher avec succes",
                "compte"=>$fact
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


// afficher les factures avec les identifiants

function getPharmacieFactureId(Request $request)
{
    try {
            $factId=Facture::firstwhere("id",$request->id);
                return response()->json([
                    "statusCode"=>200,
                    "status"=>true,
                    "message"=>"ordonnance id effectué",
                    "ordonnance"=> $factId
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

// afficher les facture avec leur status
function getFactureStatus(Request $request)
{
    try {
            $StatusFact=Ordonnance::firstwhere("payement",$request->payement);
            return response()->json([
                "statusCode"=>200,
                "status"=>true,
                "message"=>"ordonnance status effectué",
                "ordonnance"=>$StatusFact
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
