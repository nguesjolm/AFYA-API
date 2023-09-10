<?php

namespace App\Http\Controllers;

use App\Models\Pharmacy;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class PharmacieController extends Controller
{
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





}
