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



class PatientController extends Controller
{
    /**
       * ------------------
       *  AUTHENTIFICATION
       * -----------------
    */
      //inscription
      function inscriptionPatient(Request $request)
      {
        try {
            //step 1 : Validation des données

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
                         'message' => 'Veuillez entrer votre prénom minimum 4 caractères',
                         'errors' => $validatePrenom->errors()
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
                //Telephone
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

                // Email
                // $validateMail = Validator::make($request->all(),
                // [
                //     'Email' =>'required',
                // ]);
                // if ($validateMail->fails()) {
                //     return response()->json([
                //         'statusCode' => 401,
                //         'status' =>false,
                //         'message' =>'email est incorrect ou déjà utilisé',
                //         'errors' => $validateMail->errors()
                //     ],401);
                // }
                //Mot de passe
                $validatePass = Validator::make($request->all(),
                [
                    'password' => 'required|min:8',
                ]);
                if ($validatePass->fails()) {
                    return response()->json([
                        'statusCode' => 401,
                        'status' => false,
                        'message' => 'Mot de passe minimum 8 caractères',
                        'errors' => $validatePass->errors()
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

            //step2 : ouverture de compte
                $user = User::create([
                    'phone' => $request->telephone,
                ]);

                $patient = Patient::create([
                    'nom'        => $request->nom,
                    'prenom'     => $request->prenom,
                    'date_naissance' => $request->date_naissance,
                    'genre'      => $request->genre,
                    'telephone'  => $request->telephone,
                    'password'   => $request->password,
                    'profession' => $request->profession,
                    'id_users'   => $user->id,
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

      //connection
      //generate OTP
      //check OTP





        function getAllFacture(Request $request)
        {
           try {
                $user = Auth::user();
                // $patient = Patient::get();
                $facture = Facture::all();
                return response()->json([
                    'statuscode'=>200,
                    'status'  => true,
                    'message' => "affichage de la liste des factures",
                    'user'    => $user,
                    'facture' => $facture,
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


        function getOneFactureById(Request $request)
        {
           try {
                $user = Auth::user();
                $facture = Facture::Find($request->id);
                return response()->json([
                    'statuscode'=>200,
                    'status'  => true,
                    'message' => "afficher la facture avec l'id",
                    'user'    => $user,
                    'facture' => $facture
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

        function getFactureByStatus(Request $request)
        {
            try {
                 $user = Auth::user();
                 $facture = Facture::all()->where('payement',$request->payement);

                 if ($facture === "1") {
                    return response()->json([
                        'statuscode'=>200,
                        'status' => true,
                        'message'=>'la liste des factures payé',
                        'user'   => $user,
                        'facture'=>$facture
                    ],200);
                 }else{
                    return response()->json([
                        'statuscode'=>500,
                        'status'  => false,
                        'message' => "la liste des non factures payé",
                        'user'    => $user,
                        'facture' => $facture
                    ], 500);
                 }


            } catch (\Throwable $th) {
                return response()->json([
                    'statuscode'=>500,
                    'status' => false,
                    'message' => $th->getMessage()
                ], 500);
            }
        }





        //  ORDONNACES
        function getAllOrdonnance(Request $request)
        {
            try {
                 $user = Auth::user();
                 $ordonnance = Ordonnance::all();
                 return response()->json([
                    'statuscode'=>200,
                    'status'  => true,
                    'message' => "afficher les ordonnances avec le statut",
                    'user'    => $user,
                    'ordonnance' => $ordonnance
                ], 200);

            } catch (\Throwable $th) {
                return response()->json([
                    'statuscode'=>500,
                    'status' => false,
                    'message' => $th->getMessage()
                ], 500);
            }
        }


        function getOrdonnanceByStatus(Request $request)
        {
            try {
                 $user = Auth::user();
                 $ordonnance = Ordonnance::all()->where('delivery_state',$request->delivery_state);
                 return response()->json([
                    'statuscode'=>200,
                    'status'  => true,
                    'message' => "afficher les ordonnances avec le statut",
                    'user'    => $user,
                    'ordonnance' => $ordonnance
                ], 200);

            } catch (\Throwable $th) {
                return response()->json([
                    'statuscode'=>500,
                    'status' => false,
                    'message' => $th->getMessage()
                ], 500);
            }
        }

}

