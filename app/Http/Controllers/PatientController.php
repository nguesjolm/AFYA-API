<?php

namespace App\Http\Controllers;

use App\Models\Facture;
use App\Models\Ordonnance;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Patient;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Stmt\TryCatch;



class Patientcontroller extends Controller
{
    function sendOrdonnance(request $request)
    {
        try {
             /**
          * step 1 : Validation des données
          */
          //photo_1
          $validatephoto_1 = Validator::make($request->all(), 
          [
              'photo_1' => 'required',
          ]);
          if ($validatephoto_1->fails()) {
              return response()->json([
                  'statusCode' => 401,
                  'status' => false,
                  'message' => 'Veuillez entrer votre nom minimum 3 caract^ères',
                  'errors' => $validatephoto_1->errors()
              ], 401);
          }
            //photo_2
            $validatephoto_2 = Validator::make($request->all(), 
            [
                'photo_2' => 'required',
            ]);
            if ($validatephoto_2->fails()) {
                return response()->json([
                    'statusCode' => 401,
                    'status' => false,
                    'message' => 'Veuillez entrer votre prénom minimum 4 caractères',
                    'errors' => $validatephoto_2->errors()
                ], 401);
            }
               //photo_3
               $validatephoto_3 = Validator::make($request->all(), 
               [
                   'photo_3' => 'required',
               ]);
               if ($validatephoto_3->fails()) {
                   return response()->json([
                       'statusCode' => 401,
                       'status' => false,
                       'message' => 'Veuillez préciser votre date de naissance',
                       'errors' => $validatephoto_3->errors()
                   ], 401);
               }
                  //writing
          
             $validatewriting = Validator::make($request->all(), 
             [
                 'writing' => 'required',
             ]);
             if ($validatewriting->fails()) {
                 return response()->json([
                     'statusCode' => 401,
                     'status' => false,
                     'message' => 'Veuillez préciser votre writing',
                     'errors' => $validatewriting->errors()
                 ], 401);
             }
                //prescription_audio
                $validateprescription_audio = Validator::make($request->all(), 
                [
                    'prescription_audio' => 'required',
                ]);
                if ($validateprescription_audio->fails()) {
                    return response()->json([
                        'statusCode' => 401,
                        'status' => false,
                        'message' => 'Numero de téléphone incorrecte ou existe déjà',
                        'errors' => $validateprescription_audio->errors()
                    ], 401);
                }
                 //prescription_video
              $validateprescription_video= Validator::make($request->all(), 
              [
                  'prescription_video' => 'required',
              ]);
              if ($validateprescription_video->fails()) {
                  return response()->json([
                      'statusCode' => 401,
                      'status' => false,
                      'message' => 'prescription_videoincorrecte ou existe déjà',
                      'errors' => $validateprescription_video->errors()
                  ], 401);
              }
                     
             //prescription_texte
             $validateprescription_texte = Validator::make($request->all(), 
             [
                 'prescription_texte' => 'required',
             ]);
             if ($validateprescription_texte->fails()) {
                 return response()->json([
                     'statusCode' => 401,
                     'status' => false,
                     'message' => 'Mot de passe minimum 8 caractères',
                     'errors' => $validateprescription_texte->errors()
                 ], 401);
             }
             
              //date_soumission
              $validatedate_soumission = Validator::make($request->all(), 
              [
                  'date_soumission' => 'required',
              ]);
              if ($validatedate_soumission->fails()) {
                  return response()->json([
                      'statusCode' => 401,
                      'status' => false,
                      'message' => 'Numero  incorrecte ou existe déjà',
                      'errors' => $validatedate_soumission->errors()
                  ], 401);
              }
                 //longitude
             $validatelongitude = Validator::make($request->all(), 
             [
                 'longitude' => 'required',
             ]);
             if ($validatelongitude->fails()) {
                 return response()->json([
                     'statusCode' => 401,
                     'status' => false,
                     'message' => 'Veillez rensegner votre',
                     'errors' => $validatelongitude->errors()
                 ], 401);
             }
             
             //latitude
             $validatelatitude = Validator::make($request->all(), 
             [
                 'latitude' => 'required',
             ]);
             if ($validatelatitude->fails()) {
                 return response()->json([
                     'statusCode' => 401,
                     'status' => false,
                     'message' => 'veillez rensegner la latitude',
                     'errors' => $validatelatitude->errors()
                 ], 401);
             }
             
              //delivery_state
              $validatedelivery_state = Validator::make($request->all(), 
              [
                  'delivery_state' => 'required',
              ]);
              if ($validatedelivery_state->fails()) {
                  return response()->json([
                      'statusCode' => 401,
                      'status' => false,
                      'message' => 'veillez rensegner la commune ou le quartier',
                      'errors' => $validatedelivery_state->errors()
                  ], 401);
              }
              
                //payement
                $validatepayement = Validator::make($request->all(), 
                [
                    'payement' => 'required',
                ]);
                if ($validatepayement->fails()) {
                    return response()->json([
                        'statusCode' => 401,
                        'status' => false,
                        'message' => 'veillez rensegner le payement',
                        'errors' => $validatepayement->errors()
                    ], 401);
                }   
                
                //numero_ordonnance
                 
                $validatenumero_ordonnance = Validator::make($request->all(), 
                [
                    'numero_ordonnance' => 'required',
                ]);
                if ($validatenumero_ordonnance->fails()) {
                    return response()->json([
                        'statusCode' => 401,
                        'status' => false,
                        'message' => 'veillez rensegner le numero_ordonnance',
                        'errors' => $validatenumero_ordonnance->errors()
                    ], 401);
                }
                
         //step2 : ouverture de compte

             $user=User::create([]);
             $ordonnance = Ordonnance::create([
                'photo_1'        => $request->photo_1,
                'photo_2'     => $request->photo_2,
                'photo_3' => $request->photo_3,
                'writing'      => $request->	writing,
                'prescription_audio'  => $request->prescription_audio,
                'prescription_video'      => $request ->prescription_video,
                'prescription_texte' => $request ->prescription_texte,
                'date_soumission' => $request->date_soumission,
                'longitude'        => $request ->longitude,
               'latitude'       => $request ->latitude,
               'delivery_state' => $request ->delivery_state,
               'payement' => $request->payement,
               'numero_ordonnance' => $request->numero_ordonnance,
               'patients_id '   => $request->patient_id,
               'livreurs_id '   => $request->livreur_id,
               //'user_id'=>$user->id,
             ]);
             
         //step3 : generation de token

         return response()->json([
            'statusCode' => 200,
            'status'   => true,
            'message'  => 'compte ordonnance ouvert avec succès',
            'ordonnance'  =>$ordonnance,
            'token'   => $user->createToken("API TOKEN")->plainTextToken
        ], 200);

        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'statusCode' => 500,
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
 
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    //authentification//
    //inscription//
    function inscriptionPatient(Request $request)
    {
     try {
         //step 1 : Validation des données
             //Tel
             $validateTel = Validator::make($request->all(), 
             [
                 'telephone' => 'required|min:10|unique:patients',
             ]);
             if ($validateTel->fails()) {
                 return response()->json([
                     'statusCode' => 401,
                     'status' => false,
                     'message' => 'Numero de téléphone incorrecte ou ce compte existe déjà',
                     'errors' => $validateTel->errors()
                 ], 401);
             }
             //Mot de passe
             $validatePass = Validator::make($request->all(), 
             [
                 'mot_passe' => 'required|min:8',
             ]);
             if ($validatePass->fails()) {
                 return response()->json([
                     'statusCode' => 401,
                     'status' => false,
                     'message' => 'Mot de passe minimum 8 caractères',
                     'errors' => $validatePass->errors()
                 ], 401);
             }
             //date de naissance
             $validateDateNais = Validator::make($request->all(), 
             [
                 'date_naissance' => 'required',
             ]);
             if ($validateDateNais->fails()) {
                 return response()->json([
                     'statusCode' => 401,
                     'status' => false,
                     'message' => 'Veuillez préciser votre date de naissance',
                     'errors' => $validateDateNais->errors()
                 ], 401);
             }
             //genre
             $validateGenre = Validator::make($request->all(), 
             [
                 'genre' => 'required',
             ]);
             if ($validateGenre->fails()) {
                 return response()->json([
                     'statusCode' => 401,
                     'status' => false,
                     'message' => 'Veuillez préciser votre genre',
                     'errors' => $validateGenre->errors()
                 ], 401);
             }
             //profession
             $validateProfession = Validator::make($request->all(), 
             [
                 'profession' => 'required',
             ]);
             if ($validateProfession->fails()) {
                 return response()->json([
                     'statusCode' => 401,
                     'status' => false,
                     'message' => 'Veuillez préciser votre profession',
                     'errors' => $validateProfession->errors()
                 ], 401);
             }
             //nom
             $validateNom = Validator::make($request->all(), 
             [
                 'nom' => 'required|min:3',
             ]);
             if ($validateNom->fails()) {
                 return response()->json([
                     'statusCode' => 401,
                     'status' => false,
                     'message' => 'Veuillez entrer votre nom minimum 3 caract^ères',
                     'errors' => $validateNom->errors()
                 ], 401);
             }
             //prenom
             $validatePrenom = Validator::make($request->all(), 
             [
                 'prenom' => 'required|min:4',
             ]);
             if ($validatePrenom->fails()) {
                 return response()->json([
                     'statusCode' => 401,
                     'status' => false,
                     'message' => 'Veuillez entrer votre prénom minimum 4 caract^ères',
                     'errors' => $validatePrenom->errors()
                 ], 401);
             }

            //step2 : ouverture de compte
             $user = User::create([
                 'phone' => $request->telephone,
             ]);

             $password = Hash::make($request->mot_passe); 

             $patient = Patient::create([
                 'nom'            => $request->nom,
                 'prenom'         => $request->prenom,
                 'date_naissance' => $request->date_naissance,
                 'genre'          => $request->genre,
                 'telephone'      => $request->telephone,
                 'password'       => $password,
                 'profession'     => $request->profession,
                 'parrainage'     => $request->parainage,
                 'ville'           => $request->ville,
                 'commune_quartier' => $request->commune_quartier,   
                 'id_users'       => $user->id,  
             ]);
         //step3 : generation de token
         return response()->json([
             'statusCode' => 200,
             'status'   => true,
             'message'  => 'compte patient ouvert avec succès',
             'patient'  =>$patient,
             'token'   => $user->createToken("API TOKEN")->plainTextToken
         ], 200);
     } catch (\Throwable $th) {
         //throw $th;
         return response()->json([
             'statusCode' => 500,
             'status' => false,
             'message' => $th->getMessage()
         ], 500);
     }
    }

    //login patient
    function loginPatient(Request $request)
    {
        try {
            $validePatient = Validator::make($request->all(),[
                'tel'      => 'required',
                'password' => 'required',
            ]);
            if ($validePatient->fails()) {
                return response()->json([
                    'statusCode' => 401,
                    'status' => false,
                    'message' => 'Numero de téléphone et mot de passe obligatoire',
                    'errors' => $validePatient->errors()
                ], 401);
            }
            #Vérifier les données de connection
            $patient = Patient::firstWhere('telephone',$request->tel);
            $check = Hash::check($request->password, $patient->password);
            if ($check) {
                $user = User::firstWhere('phone', $request->tel)->first();
                return response()->json([
                    "statuscode"=>200,
                    "status"    =>true,
                    "message"   =>"connecté avec succès",
                    "patient"   =>$patient,
                    "token"     =>$user->createToken("API TOKEN")->plainTextToken
                 ],200);
            }else{
                return response()->json
                ([
                    "statuscode"=>401,
                    "status"=>true,
                    "message"=>"mot de passe ou telephone incorrecte",
                    "patient"=>[],
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

    //Generate OTP
    function generateOtp(Request $request)
    {
        try {
            $valideTel = Validator::make($request->all(),[
                'tel'      => 'required|min:10'
            ]);
            if ($valideTel->fails()) {
                return response()->json([
                    'statusCode' => 401,
                    'status' => false,
                    'message' => 'Numero de téléphone incorrecte',
                    'errors' => $valideTel->errors()
                ], 401);
            }

            #Send OTP code to phone
            return GenerateCode();


        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'statusCode' => 500,
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

   ////////////////////////////////////////////////////////////////
   function getAllOrdonnance(request $request)
   {
                  try {
                    $Ordonnance = Ordonnance::all();
            if(count($Ordonnance)!=0)
            {
                return response()->json
                ([
                    "statuscode"=>200,
                    "status"=>true,
                    "message"=>"all users",
                    "Ordonnance"=>$Ordonnance
                 ],200);
            }
            else
            {
                return response()->json
                ([
                    "statuscode"=>404,
                    "status"=>false,
                    "message"=>"aucune Ordonnance",
                    "Ordonnance"=>""
                 ],404);

            }
                  } catch (\Throwable $th){
                    return response()->json
                    ([
                        "statuscode"=>500,
                        "status"=>false,
                        "message"=>" recuperation des donnees non effectuers",
                        "message"=>$th->getmessage()
                     ],500);
                    
                  
                  }
                  function getOrdonnanceByStatus
                  (request $request)
                  {
                    try {
                        
                    $Ordonnance = Ordonnance::all();
                    if(count($Ordonnance)!=0)
                    {
                        return response()->json
                        ([
                            "statuscode"=>200,
                            "status"=>true,
                            "message"=>"all users",
                            "Ordonnance"=>$Ordonnance
                         ],200);
                    }
                    else
                    {
                        return response()->json
                        ([
                            "statuscode"=>404,
                            "status"=>false,
                            "message"=>"aucune Ordonnance",
                            "Ordonnance"=>""
                         ],404);
        
                    }
                        
                    } catch (\Throwable $th) {
                        return response()->json
                        ([
                            "statuscode"=>500,
                            "status"=>false,
                            "message"=>" recuperation des donnees non effectuers",
                            "message"=>$th->getmessage()
                         ],500);
                        
                    }
                  }
   }
   /////////////////////////////////////////////////////////////
          function updateOrdonStatus (request $request)
        {
         try {
            $user=User::create([]);
            $photo_1            = $request->photo_1;
            $photo_2            = $request->photo_2;
            $photo_3            = $request->photo_3;
            $writing            = $request->adresse_pharma;
            $prescription_audio = $request->prescription_audio;
            $prescription_video = $request->prescription_video;
            $prescription_texte = $request->prescription_texte; 
            $date_soumission    = $request->date_soumission;
            $longitude          = $request->longitude;
            $latitude           = $request->latitude;
            $latitude           = $request->latitude;
            $delivery_state     = $request->delivery_state;
            $payement           = $request->payement;
            $numero_ordonnance  = $request->numero_ordonnance;
            $patients_id        = $request->patients_id;
            $livreurs_id        = $request->livreurs_id;
            // la mise a jour de du writing//
            $updateinfosordon=Ordonnance::where()->update(["writing" =>  $writing ]);  
            // dans le cas ou la mise a jour n'est pas effectuée//
            if($updateinfosordon==0)
            {
                return response()->json
                ([
                    "statuscode"=>200,
                    "status"=>false,
                    "message"=>"aucune mise a jour effectuée ",
                    "Donnepharma"=>""
                 ],200);
            }
            // la reussite de la modification des informations//
            else {
                return response()->json
                ([
                    "statuscode"=>200,
                    "status"=>true,
                    "message"=>"update succeful",
                    "Donnepharma"=>""
                 ],200);

            }
                } catch (\Throwable $th) {
                    return response()->json
                    ([
                        "statuscode"=>500,
                        "status"=>false,
                        "message"=>"mise a jour non effectuee ",
                        "message"=>$th->getmessage()
                     ],500);
                    
                }

   }
   function getOneOrdonById(request $request)
   {
    try {
        //code...
        $Ordonnance = Ordonnance::all();
        if(count($Ordonnance)!=0)
        {
            return response()->json
            ([
                "statuscode"=>200,
                "status"=>true,
                "message"=>"all users",
                "Ordonnance"=>$Ordonnance
             ],200);
        }
        else
        {
            return response()->json
            ([
                "statuscode"=>404,
                "status"=>false,
                "message"=>"aucune Ordonnance",
                "Ordonnance"=>""
             ],404);

        }
    } catch (\Throwable $th) {
        //throw $th;
        return response()->json
        ([
            "statuscode"=>500,
            "status"=>false,
            "message"=>" recuperation des donnees non effectuers",
            "message"=>$th->getmessage()
         ],500);
    }
   }
}
 
 
