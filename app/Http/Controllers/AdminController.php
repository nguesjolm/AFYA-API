<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gestionnaire;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class Admincontroller extends Controller
{
   
    // ADMIN //


     //authentification//
   /*********************
   inscription
   *********************/
   function inscription(Request $request)
   {
    // dd($request);
     try {
         //step 1 : Validation des données
             //Tel
             $validateTelephone = Validator::make($request->all(), 
             [
                 'telephone' => 'required|min:10|unique:gestionnaires',
             ]);
             if ($validateTelephone->fails()) {
                 return response()->json([
                     'statusCode' => 401,
                     'status' => false,
                     'message' => 'Numero de téléphone incorrecte ou ce compte existe déjà',
                     'errors' => $validateTelephone->errors()
                 ], 401);
             }
          
              //password
              $validatePassword = Validator::make($request->all(), 
              [
                  'password' => 'required|min:8|unique:gestionnaires',
              ]);
              if ($validatePassword->fails()) {
                  return response()->json([
                      'statusCode' => 401,
                      'status' => false,
                      'message' => 'email incorrecte ou ce compte existe déjà',
                      'errors' => $validatePassword->errors()
                  ], 401);
              }

             //date de naissance
             $validateDate_naiss = Validator::make($request->all(), 
             [
                 'date_naissance' => 'required',
             ]);
             if ($validateDate_naiss->fails()){
                 return response()->json([
                     'statusCode' => 401,
                     'status' => false,
                     'message' => 'Veuillez préciser votre date de naissance',
                     'errors' => $validateDate_naiss->errors()
                 ], 401);
             }
            
             //DOMICILE
             $validateDomicile= Validator::make($request->all(), 
             [
                 'domicile' => 'required',
             ]);
             if ($validateDomicile->fails()) {
                 return response()->json([
                     'statusCode' => 401,
                     'status' => false,
                     'message' => 'Veuillez préciser votre domicile',
                     'errors' => $validateDomicile->errors()
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
             //email
             $validateEmail = Validator::make($request->all(), 
             [
                 'email' =>'required|unique:gestionnaires',
             ]);
             if ($validateEmail->fails()) {
                 return response()->json([
                     'statusCode' => 401,
                     'status' => false,
                     'message' => 'Veuillez entrer votre Email SVP',
                     'errors' => $validateEmail->errors()
                 ], 401);
             }
             //cni
              $validateCni= Validator::make($request->all(), 
              [
                  'cni' =>'required',
              ]);
              if ($validateCni->fails()) {
                  return response()->json([
                      'statusCode' => 401,
                      'status' => false,
                      'message' => 'Veuillez entrer votre numero cni SVP',
                      'errors' => $validateCni->errors()
                  ], 401);
              }
              //ville 
             $validateVille = Validator::make($request->all(), 
             [
                 'ville' =>'required',
             ]);
             if ($validateVille->fails()) {
                 return response()->json([
                     'statusCode' => 401,
                     'status' => false,
                     'message' => 'Veuillez entrer votre ville SVP',
                     'errors' => $validateVille->errors()
                 ], 401);
             }
             //commune_quartier 
              $validateCommune = Validator::make($request->all(), 
              [
                  'commune' =>'required',
              ]);
              if ($validateCommune->fails()) {
                  return response()->json([
                      'statusCode' => 401,
                      'status' => false,
                      'message' => 'Veuillez entrer votre commune et quartier  SVP',
                     'errors' => $validateCommune->errors()
                  ], 401);
              }
              //actif
            
             $validateActif = Validator::make($request->all(), 
             [
                 'actif' =>'required',
             ]);
             if ($validateActif->fails()) {
                 return response()->json([
                     'statusCode' => 401,
                     'status' => false,
                     'message' => 'est ce que vous etes actif',
                     'errors' => $validateActif->errors()
                 ], 401);
             }
             
         //step2 : ouverture de compte
             $user = User::create([
                 'phone' => $request->telephone,
             ]);
             $password = Hash::make($request->password);
             $Gestionnaire = Gestionnaire::create([
                 'nom'        => $request->nom,
                 'prenom'     => $request->prenom,
                 'password' => $password,
                 'date_naissance' => $request->date_naissance,
                 'genre'      => $request->genre,
                 'telephone'  => $request->telephone,
                  'email'=> $request->email,
                  'cni'=>$request->cni,
                  'ville'=>$request->ville,
                  'commune'=>$request->commune,
                  'actif'=>$request->actif,
                 'domicile' => $request->domicile,
                 'id_users'   => $user->id
             ]);
         //step3 : generation de token
         return response()->json([
             'statusCode' => 200,
             'status'   => true,
             'message'  => 'compte Gestionnaire ouvert avec succès',
             'Gestionnaire'  =>$Gestionnaire,
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

   /*********************
   connexion
   *********************/
  function connectionAdmin(Request $request)
  {
    try {
        $valideGestionnaire = Validator::make($request->all(),[
            'tel'      => 'required',
            'password' => 'required',
        ]);
        if ($valideGestionnaire->fails()) {
            return response()->json([
                'statusCode' => 401,
                'status' => false,
                'message' => 'Numero de téléphone et mot de passe obligatoire',
                'errors' => $valideGestionnaire->errors()
            ], 401);
        }
        #Vérifier les données de connection
        $gestionnaire = Gestionnaire::firstWhere('telephone',$request->tel);
        $check = Hash::check($request->password, $gestionnaire->password);
        if ($check) {
            $user = User::firstWhere('phone', $request->tel)->first();
            return response()->json([
                "statuscode"=>200,
                "status"    =>true,
                "message"   =>"connecté avec succès",
                "gestionnaire"   =>$gestionnaire,
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

    /*********************
     afficher les données de l'admin
    *********************/

  function getAdmincount( Request $request)
  {
    
    $user = Auth::user();
    // $admin = $user->id;
    $gestionnaire = Gestionnaire::firstWhere('id_users',$user->id);
   
    if ($gestionnaire) {
       return response()->json([
           'statusCode' => 200,
           'status' => true,
           'message' => 'Compte gestionnaire',
           'gestionnaire' => $gestionnaire
       ], 200);
    }else{
       return response()->json([
           'statusCode' => 404,
           'status' => false,
           'message' => "Ce compte n'existe pas",
           'gestionnaire' => $gestionnaire
       ], 200);
    }
  }

  /*********************
   modifier les données de l'admin
   *********************/

   function updateAdmincount( Request $request)
   {

            #Reception des données
              $user = Auth::user();
            $gestionnaire = Gestionnaire::firstWhere('id_users',$user->id);
                //nom
                if ($request->nom) {
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
                    #Modification en fonction de l'id gestionnaire et l'id_user de la table gestionnaire
                    Gestionnaire::where('id', $gestionnaire->id)
                            ->where('id_users', $user->id)
                            ->update(['nom' => $request->nom]);
                }

        //prenom
        if ($request->prenom) {
            $validateprenom = Validator::make($request->all(), 
            [
                'prenom' => 'required|min:3',
            ]);
            if ($validateprenom->fails()) {
                return response()->json([
                    'statusCode' => 401,
                    'status' => false,
                    'message' => 'Veuillez entrer votre prenom minimum 3 caract^ères',
                    'errors' => $validateprenom->errors()
                ], 401);
            }
            #Modification en fonction de l'id gestionnaire et l'id_user de la table gestionnaire
            Gestionnaire::where('id', $gestionnaire->id)
                    ->where('id_users', $user->id)
                    ->update(['prenom' => $request->prenom]);

        }

        //date_naissance
        if ($request->date_naissance) {
           
            #Modification en fonction de l'id gestionnaire et l'id_user de la table gestionnaire
            Gestionnaire::where('id', $gestionnaire->id)
                    ->where('id_users', $user->id)
                    ->update(['date_naissance' => $request->date_naissance]);
        }

        

        //telephone
        if ($request->telephone) {
            $validateTelephone = Validator::make($request->all(), 
            [
                'telephone' => 'required|min:10|unique:patients',
            ]);
            if ($validateTelephone->fails()) {
                return response()->json([
                    'statusCode' => 401,
                    'status' => false,
                    'message' => 'Ce téléphone existe déjà',
                    'errors' => $validateTelephone->errors()
                ], 401);
            }
            #Modification en fonction de l'id gestionnaire et l'id_user de la table gestionnaire
            Gestionnaire::where('id', $gestionnaire->id)
                    ->where('id_users', $user->id)
                    ->update(['telephone' => $request->nom]);

        }

        //Email
        if ($request->Email) {
            $validateEmail = Validator::make($request->all(), 
            [
                'Email' => 'email',
            ]);
            if ($validateEmail->fails()) {
                return response()->json([
                    'statusCode' => 401,
                    'status' => false,
                    'message' => 'Veuillez entrer votre email',
                    'errors' => $validateEmail->errors()
                ], 401);
            }
            #Modification en fonction de l'id gestionnaire et l'id_user de la table gestionnaire
            Gestionnaire::where('id', $gestionnaire->id)
                    ->where('id_users', $user->id)
                    ->update(['email' => $request->email]);

        }

        //ville
        if ($request->ville) {
            #Modification en fonction de l'id gestionnaire et l'id_user de la table gestionnaire
            Gestionnaire::where('id', $gestionnaire->id)
                    ->where('id_users', $user->id)
                    ->update(['ville' => $request->ville]);

        }

        //Email
        if ($request->Email) {
            $validateEmail = Validator::make($request->all(), 
            [
                'domicile' => 'domicile',
            ]);
            if ($validateEmail->fails()) {
                return response()->json([
                    'statusCode' => 401,
                    'status' => false,
                    'message' => 'Veuillez entrer votre domicile',
                    'errors' => $validateEmail->errors()
                ], 401);
            }
            #Modification en fonction de l'id gestionnaire et l'id_user de la table gestionnaire
            Gestionnaire::where('id', $gestionnaire->id)
                    ->where('id_users', $user->id)
                    ->update(['domicile' => $request->domiciel]);

        }


        //commune - quartier
        if ($request->commune_quartier) {
            $validatecommune_quartier= Validator::make($request->all(), 
            [
                'commune_quartier' => 'required|min:3',
            ]);
            if ($validatecommune_quartier->fails()) {
                return response()->json([
                    'statusCode' => 401,
                    'status' => false,
                    'message' => 'Veuillez entrer votre commmune minimum 3 caract^ères',
                    'errors' => $validatecommune_quartier->errors()
                ], 401);
            }
            #Modification en fonction de l'id gestionnaire et l'id_user de la table gestionnaire
            Gestionnaire::where('id', $gestionnaire->id)
                    ->where('id_users', $user->id)
                    ->update(['commune_quartier' => $request->commune_quartier]);

        }

        #Retour
        $gestionnaire = Gestionnaire::firstWhere('id_users',$user->id);
        return response()->json([
            'statusCode' => 200,
            'status' => true,
            'message' => 'Compte admin modifié avec succès',
            'gestionnaire' => $gestionnaire
        ], 200);
   

   }


   // SUPERVISEUR //

   function listedessuperviseurs( Request $request )
   {
    // $user = Auth::user();
    $gestionnaire = Gestionnaire::firstWhere('id_users',$request->id);
    if ($gestionnaire) {
       return response()->json([
           'statusCode' => 200,
           'status' => true,
           'message' => 'Compte gestionnaire',
           'gestionnaire' => $gestionnaire
       ], 200);
    }else{
       return response()->json([
           'statusCode' => 404,
           'status' => false,
           'message' => "Ce compte n'existe pas",
           'gestionnaire' => $gestionnaire
       ], 200);
    }
  }
}
