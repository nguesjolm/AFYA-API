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

     function inscriptionpharmacie(Request $request)
     {
        try {

            //validation du nom de la pharmacy
            $validateNom= validator::make($request->all(),[
                "nom"=> 'required',
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
                "telephone"=> 'required|min:10|unique:pharmacies',
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
                "Email"=> 'required',
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
                "ville"=> 'required',
            ]);
            if($validateVil->fails()){
                return response()->json([
                    "statuscode"=>401,
                    "status"=>false,
                    "message"=>"veillez saisir votre ville",
                    'errors' => $validateVil->errors()
                ],401);
              
            }            

            //validation de la commune ou quartier
            $validateCq= validator::make($request->all(),[
                "commune_quartier"=> 'required',
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
                "localisation"=> 'required',
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
                "garde"=> 'required',
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
                "longitude"=> 'required',
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
                "latitude"=> 'required',
            ]);
            if($validateLarg->fails()){
                return response()->json([
                    "statuscode"=>401,
                    "status"=>false,
                    "message"=>"veillez saisir votre email",
                    'errors' => $validateLarg->errors()
                ],401);
              
            }



            // creation de compte pharmacy

            $user=User::create([
                'phone' => $request->telephone,
            ]);

            $Pharmacy=Pharmacy::create([

                
                'zone_supervisions_id' =>$request->zone_supervisions_id,
                'nom'                  =>$request->nom,
                'telephone'            =>$request->telephone,
                'Email'                =>$request->Email,
                'ville'                =>$request->ville,
                'commune_quartier'     =>$request->commune_quartier,
                'localisation'         =>$request->localisation,
                'garde'                =>$request->garde,
                'longitude'            =>$request->longitude,
                'latitude'             =>$request->latitude,
                'id_users'            =>$user->id,
            ]);

            //generation de token

            return response()->json([
                "statusCode"=>200,
                "status"    =>True,
                "Message"   =>"votre compte est ouvert avec success",
                "pharmacy"   =>$Pharmacy,
                

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

    function loginPharmacie(Request $request)
    {
        try {
            // validation des données
             $validateLoginp= validator::make($request->all(),[
                "telephone"=>"required",
             ]);

             if($validateLoginp->fails()){
                return response()->json([
                    'statusCode' => 401,
                    'status' => false,
                    'message' => 'Numero de téléphone obligatoire',
                    'errors' => $validateLoginp->errors()
                ], 401);
            }
            #Vérifier les données de connection
            $pharmacie =Pharmacy::firstWhere('telephone',$request->telephone);
            if ($pharmacie) {
                $user =User::firstWhere('phone', $request->phone)->first();
                return response()->json([
                    "statuscode"=>200,
                    "status"    =>true,
                    "message"   =>"connecté avec succès",
                    "pharmacie"   =>$pharmacie,
                    "token"     =>$user->createToken("API TOKEN")->plainTextToken
                 ],200);
            }else{
                return response()->json
                ([
                    "statuscode"=>401,
                    "status"=>false,
                    "message"=>" telephone incorrecte",
                    
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
     * -------
     * compte
     * -------
     */
    
 // afficher tous les informations de la pharmacie connecté
 function pharmacieCount(Request $request)
 
 {
   
    $user = Auth::user();
    
    $pharma = Pharmacy::firstWhere('id_users',$user->id);
    
    if ($pharma) {
       return response()->json([
           'statusCode' => 200,
           'status' => true,
           'message' => 'Compte patient afficher avec succes ',
           'pharmacy' => $pharma
       ], 200);

    }
    else
    {
       return response()->json([
           'statusCode' => 404,
           'status' => false,
           'message' => "Ce compte n'existe pas",
           
       ], 404);
    }
 }

    function updatePharmacieCount(Request $request)
    {
        try {
           // reception des données
           $user = Auth::user();
           $pharma = Pharmacy::firstWhere('id_users',$user->id);
           //fin

           if($request->zone_supervisions_id)
           {
              
           // validation des données
            $validateZoneSup= validator::make($request->all(),[
               "zone_supervisions_id"=>"required",
            ]);

            //verification des données entrées
            if($validateZoneSup->fails()){
               return response()->json([
                   'statusCode' => 401,
                   'status' => false,
                   'message' => 'zone_supervisions_id obligatoire',
                   'errors' => $validateZoneSup->errors()
               ], 401);

           //modification des information du livreurs
           } 
           Pharmacy::where('id', $pharma->id)
           ->where('id_users', $user->id)
           ->update(['zone_supervisions_id' => $request->zone_supervisions_id]);


       }

       // nom update

       if($request->nom)
       {
          
       // validation des données
        $validateNom= validator::make($request->all(),[
           "nom"=>"required",
        ]);

        //verification des données entrées
        if($validateNom->fails()){
           return response()->json([
               'statusCode' => 401,
               'status' => false,
               'message' => 'Zone de supervision obligatoire',
               'errors' => $validateNom->errors()
           ], 401);

       //modification des information du livreurs
       } 
       Pharmacy::where('id', $pharma->id)
       ->where('id_users', $user->id)
       ->update(['nom' => $request->nom]);


   }
   
           // telephone update

           if($request->telephone)
           {
              
           // validation des données
            $validate_tel= validator::make($request->all(),[
               "telephone"=>"required",
            ]);
   
            //verification des données entrées
            if($validate_tel->fails()){
               return response()->json([
                   'statusCode' => 401,
                   'status' => false,
                   'message' => 'telephone obligatoire',
                   'errors' => $validate_tel->errors()
               ], 401);
   
           //modification des information du livreurs
           } 
           Pharmacy::where('id', $pharma->id)
           ->where('id_users', $user->id)
           ->update(['telephone' => $request->telephone]);
   
   
       }

       //  Email update  //

       if($request->Email)
       {
          
       // validation des données
        $validate_mail= validator::make($request->all(),[
           "Email"=>"required",
        ]);

        //verification des données entrées
        if($validate_mail->fails()){
           return response()->json([
               'statusCode' => 401,
               'status' => false,
               'message' => 'Email obligatoire',
               'errors' => $validate_mail->errors()
           ], 401);

       //modification des information du livreurs
       } 
       Pharmacy::where('id', $pharma->id)
       ->where('id_users', $user->id)
       ->update(['Email' => $request->Email]);


   }

  
           //  ville update  //

           if($request->ville)
           {
              
           // validation des données
            $validatevil= validator::make($request->all(),[
               "ville"=>"required",
            ]);
   
            //verification des données entrées
            if($validatevil->fails()){
               return response()->json([
                   'statusCode' => 401,
                   'status' => false,
                   'message' => 'ville obligatoire',
                   'errors' => $validatevil->errors()
               ], 401);
   
           //modification des information du livreurs
           } 
           Pharmacy::where('id', $pharma->id)
           ->where('id_users', $user->id)
           ->update(['ville' => $request->ville]);
   
   
       }

                   //  commune_quartier update  //

                   if($request->commune_quartier)
                   {
                      
                   // validation des données
                    $validate_CQ= validator::make($request->all(),[
                       "commune_quartier"=>"required",
                    ]);
           
                    //verification des données entrées
                    if($validate_CQ->fails()){
                       return response()->json([
                           'statusCode' => 401,
                           'status' => false,
                           'message' => 'commune_quartier obligatoire',
                           'errors' => $validate_CQ->errors()
                       ], 401);
           
                   //modification des information du livreurs
                   } 
                   Pharmacy::where('id', $pharma->id)
                   ->where('id_users', $user->id)
                   ->update(['commune_quartier' => $request->commune_quartier]);
           
           
               }

                   //  localisation update  //

                   if($request->localisation)
                   {
                      
                   // validation des données
                    $validate_loc= validator::make($request->all(),[
                       "localisation"=>"required",
                    ]);
           
                    //verification des données entrées
                    if($validate_loc->fails()){
                       return response()->json([
                           'statusCode' => 401,
                           'status' => false,
                           'message' => 'localisation obligatoire',
                           'errors' => $validate_loc->errors()
                       ], 401);
           
                   //modification des information du livreurs
                   } 
                   Pharmacy::where('id', $pharma->id)
                   ->where('id_users', $user->id)
                   ->update(['localisation' => $request->localisation]);
           
           
               }
                   //  garde update  //

                   if($request->garde)
                   {
                      
                   // validation des données
                    $validategarde= validator::make($request->all(),[
                       "garde"=>"required",
                    ]);
           
                    //verification des données entrées
                    if($validategarde->fails()){
                       return response()->json([
                           'statusCode' => 401,
                           'status' => false,
                           'message' => 'garde obligatoire',
                           'errors' => $validategarde->errors()
                       ], 401);
           
                   //modification des information du livreurs
                   } 
                   Pharmacy::where('id', $pharma->id)
                   ->where('id_users', $user->id)
                   ->update(['garde' => $request->garde]);
           
           
               }

                //  longitude update  //

                   if($request->longitude)
                   {
                      
                   // validation des données
                    $validatelong= validator::make($request->all(),[
                       "longitude"=>"required",
                    ]);
           
                    //verification des données entrées
                    if($validatelong->fails()){
                       return response()->json([
                           'statusCode' => 401,
                           'status' => false,
                           'message' => 'longitude obligatoire',
                           'errors' => $validatelong->errors()
                       ], 401);
           
                   //modification des information du livreurs
                   } 
                   Pharmacy::where('id', $pharma->id)
                   ->where('id_users', $user->id)
                   ->update(['longitude' => $request->longitude]);
           
           
               }

                   //  latitude update  //

                   if($request->latitude)
                   {
                      
                   // validation des données
                    $validatelat= validator::make($request->all(),[
                       "latitude"=>"required",
                    ]);
           
                    //verification des données entrées
                    if($validatelat->fails()){
                       return response()->json([
                           'statusCode' => 401,
                           'status' => false,
                           'message' => 'latitude obligatoire',
                           'errors' => $validatelat->errors()
                       ], 401);
           
                   //modification des information du livreurs
                   } 
                   Pharmacy::where('id', $pharma->id)
                   ->where('id_users', $user->id)
                   ->update(['latitude' => $request->latitude]);
           
           
               }
               return response()->json([
                "statusCode"=>200,
                "status"=>True,
                "message"=>"modification des information du compte effectué avec success",
                'pharmacy'   => $pharma
            ],200);




        } catch (\Throwable $th) {
            //throw $th;
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
     * ORDONNANCE
     * -----------
     */

// afficher les ordonnance dans le compte de la pharmacie
function getPharmacieOrdon(Request $request)
{
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
 function updatePharmacieOrdonStatus(Request $request)
 {
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


    function sendFacture(Request $request)
    {
       
        try {
            //validation des donnees

            // id du patient (Facture)
            $validatePat=validator::make($request->all(),[
            "patients_id"=>"required",
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
                "pharmacies_id"=>"required",
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
                "ordonnances_id"=>"required",
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
                "numero_facture"=>"required",
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
                "prix"=>"required",
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
                "description"=>"required",
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
                "montant"=>"required",
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
                "date_facture"=>"required",
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
                "payement"=>"required",
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
            $user=User::create();

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
                'token'     => $user->createToken("API TOKEN")->plainTextToken

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

function getPharmcieFacture(Request $request)
{
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
