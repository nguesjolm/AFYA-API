<?php

namespace App\Http\Controllers;

use App\Models\Pharmacy;
use App\Models\User;
use Illuminate\Http\Request;
<<<<<<< HEAD
use App\Models\Pharmacy;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
=======
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

>>>>>>> origin/pharmacie

class Pharmaciecontroller extends Controller
{
<<<<<<< HEAD
    //pharmacie //
     //authentification//
   //inscription_pharmacie//
   function inscriptionpharmacie(Request $request)
   {
     try {
         //step 1 : Validation des données
             //nom_pharmacie
             $validatenom = Validator::make($request->all(), 
             [
                 'nom' => 'required|min:4',
             ]);
             if ($validatenom->fails()) {
                 return response()->json([
                     'statusCode' => 401,
                     'status' => false,
                     'message' => 'le nom de la pharmacie doit etre au minimun 4 caractere',
                     'errors' => $validatenom->errors()
                 ], 401);
             }
             //tel_pharmacie 
             $validatetel_pharmacie = Validator::make($request->all(), 
             [
                 'tel_pharmacie' => 'required|min:10|unique:pharmacies',
             ]);
             if ($validatetel_pharmacie->fails()) {
                 return response()->json([
                     'statusCode' => 401,
                     'status' => false,
                     'message' => 'le numero de telephone doit etre de 10 chiffres ou ce compte existe deja',
                     'errors' => $validatetel_pharmacie->errors()
                 ], 401);
             }
             //mot_passe
             $validatemot_passe = Validator::make($request->all(), 
             [
                 'mot_passe' => 'required|min:8',
             ]);
             if ($validatemot_passe->fails()) {
                 return response()->json([
                     'statusCode' => 401,
                     'status' => false,
                     'message' => 'le mot de passe doit etre de 8 min',
                     'errors' => $validatemot_passe->errors()
                 ], 401);
             }
             //locatisation_pharmacie
             $validatelocatisation = Validator::make($request->all(), 
             [
                 'locatisation' => 'required',
             ]);
             if ($validatelocatisation->fails()) {
                 return response()->json([
                     'statusCode' => 401,
                     'status' => false,
                     'message' => 'emplacement de la pharmacie',
                     'errors' => $validatelocatisation->errors()
                 ], 401);
             }
             //commune_quartier
             $validatecommune_quartier= Validator::make($request->all(), 
             [
                 'commune_quartier' => 'required',
             ]);
             if ($validatecommune_quartier->fails()) {
                 return response()->json([
                     'statusCode' => 401,
                     'status' => false,
                     'message' => 'Veuillez préciser votre commune et quartier',
                     'errors' => $validatecommune_quartier->errors()
                 ], 401);
             }
             //ville
             $validateville = Validator::make($request->all(), 
             [
                 'ville' => 'required',
             ]);
             if ($validateville->fails()) {
                 return response()->json([
                     'statusCode' => 401,
                     'status' => false,
                     'message' => 'Veuillez entrer votre ville',
                     'errors' => $validateville->errors()
                 ], 401);
             }
             //Email
             $validateEmail = Validator::make($request->all(), 
             [
                 'email' =>'required|unique:pharmacies',
             ]);
             if ($validateEmail->fails()) {
                 return response()->json([
                     'statusCode' => 401,
                     'status'     => false,
                     'message'    => 'Veuillez entrer votre EMAIL',
                     'errors'     => $validateEmail->errors()
                 ], 401);
             }

         //step2 : ouverture de compte
             $User = User::create([
                 'tel_pharmacie' => $request->tel_pharmacie,
             ]);
            
             $Pharmacy = Pharmacy::create([
                 'nom'          =>  $request->nom,  
                 'mot_passe'              =>  $request->mot_passe,
                 'locatisation' =>  $request->locatisation,
                 'commune_quartier'       =>  $request->commune_quartier,
                 'ville'                  =>  $request->ville,
                 'Email'                  =>  $request->Email,
                 'profession' => $request->profession,
                 "zone_supervisions_id"=>$request->zone_supervisions_id,
                 'id_users'   => $User->id,
             ]);
         //step3 : generation de token
         return response()-> json([
             'statusCode' => 200,
             'status'     => true,
             'message'    => 'compte pharmacie ouvert avec succès',
             'patient'    => $Pharmacy,
             'token'      => $Pharmacy->createToken("API TOKEN")->plainTextToken
         ], 200);
     } catch (\Throwable $th) {
         //throw $th;
         return response()->json([
             'statusCode'=> 500,
             'status'    => false,
             'message'   => $th->getMessage()
         ], 500);
     }
   }
=======
    //
    function inscriptionPharmacie(Request $request)
    {

            try
            {

                // validation des donnees
                $validateNom = Validator::make($request->all(),
                [
                     'nom' => 'required|min:6',
                ]);
                if ($validateNom->fails()) {
                     return response()->json([
                         'statusCode' => 401,
                         'status' => false,
                         'message' => 'Veuillez entrer le nom de la pharmacie minimum 3 caractères',
                         'errors' => $validateNom->errors()
                     ], 401);
                }


                $validateTel = Validator::make($request->all(),
                [
                    'Email' => 'required|min:10|unique:pharmacies',
                ]);
                if ($validateTel->fails()) {
                    return response()->json([
                        'statusCode' => 401,
                        'status' => false,
                        'message' => 'Numero de téléphone incorrecte ou ce compte existe déjà',
                        'errors' => $validateTel->errors()
                    ], 401);
                }

                $validatePass = Validator::make($request->all(),
                [
                    'contacts' => 'required|min:8',
                ]);
                if ($validatePass->fails()) {
                    return response()->json([
                        'statusCode' => 401,
                        'status' => false,
                        'message' => 'Mot de passe minimum 8 caractères',
                        'errors' => $validatePass->errors()
                    ], 401);
                }

                $validateCommune = Validator::make($request->all(),
                [
                    'commune_quartier' => 'required|min:8',
                ]);
                if ($validateCommune->fails()) {
                    return response()->json([
                        'statusCode' => 401,
                        'status' => false,
                        'message' => 'Entrez votre commune ',
                        'errors' => $validatePass->errors()
                    ], 401);
                }

                // Ouverture de compte
                $user = User::create([
                    'phone' => $request->telephone,
                ]);

                $pharmacie = Pharmacy::create([
                    'nom'        => $request->nom,
                    'contacts'  => $request->telephone,
                    'Email'   => $request->password,
                    'commune_quartier'=>$request->commune_quartier,
                    'id_users'   => $user->id,
                ]);


                // generation du token
                return response()->json([
                    'statusCode' => 200,
                    'status'   => true,
                    'message'  => 'compte patient ouvert avec succès',
                    'pharmacie'  =>$pharmacie,
                    'token'   => $user->createToken("API TOKEN")->plainTextToken
                ], 200);

            } catch (\Throwable $th)
            {
                return response()->json([
                    'statusCode' => 500,
                    'status' => false,
                    'message' => $th->getMessage()
                ], 500);

            }


    }




    // Pharmacie compte
    function getPharmacieCount(Request $request){
        try {
             $user = Auth::user();
             $pharmacie = Pharmacy::all();
             return response()->json([
                'statuscode'=>200,
                'status'  => true,
                'message' => "mon compte",
                'user'    => $user,
                'pharmacie' => $pharmacie,
                // 'patient' =>$patient
            ], 200);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'statuscode'=>500,
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }






    function updatePharmacieCount(Request $request)
    {

        try {
            $user = Auth::user();
            $pharmacie = Pharmacy::where('id', $request->id)->update(['nom','contacts','Email','ville']);
            return response()->json([
               'statuscode'=>200,
               'status'  => true,
               'message' => "mise à jour effectué",
               'user'    => $user,
               'pharmacie' => $pharmacie,
               // 'patient' =>$patient
           ], 200);
       } catch (\Throwable $th) {
           //throw $th;
           return response()->json([
               'statuscode'=>500,
               'status' => false,
               'message' => $th->getMessage()
           ], 500);
       }
    }





>>>>>>> origin/pharmacie
}
