<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;

class PatientController extends Controller
{
    /**
     * -----------------
     *  AUTHENTIFICATION
     * -----------------
     */
      //inscription
      function inscriptionPatient(Request $request)
      {
         return "inscription patient";
      }
      //connection
      function loginPatient(Request $request)
      {
        return "connection patient";
      }
      //generer otp
      //verifier otp


   /**
    *--------------- 
    * USER
    *--------------
    */
     //create user
     function creatuser(Request $request)
     {
        try {
         //code...
         //step 1 : Recuperer les données
         $nom             = $request->nom;
         $prenom          = $request->prenom;
         $date_naissance  = $request->date_naissance;
         $genre           = $request->genre;
         $email           = $request->email;
         $tel             = $request->tel;
         $domicile        = $request->domicile;
        //step 2 : enregistre les données
         $user = Patient::create([
          'nom' =>$nom,
          'prenom' =>$prenom,
          'date_naissance' => $date_naissance ,
          'genre' =>$genre,
          'email' =>$email,
          'tel' =>$tel,
          'domicile' => $domicile
         ]);
         //step 3: Retour
         return response()->json([
            'statuscode' =>200,
            'status'     =>true,
            'message'    =>'Ouverture de compte user effectué  avec succès',
            'user'       => $user
         ],200);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
               'statuscode'=>500,
               'status' => false,
               'message' => $th->getMessage()
            ], 500);
        }

     }
     //read user
     function readuser(Request $request)
     {
       try {
         //code...
         $user = Patient::all();
         if(count($user)!=0)
         {
            return response()->json([
               'statuscode' =>200,
               'status'     =>true,
               'message'    =>'read user',
               'user'       => $user
            ],200);
         }else{
            return response()->json([
               'statuscode' =>404,
               'status'     =>false,
               'message'    =>'Aucun utilisateur',
               'user'       => ''
            ],404);
         }
       } catch (\Throwable $th) {
         //throw $th;
         return response()->json([
            'statuscode'=>500,
            'status' => false,
            'message' => $th->getMessage()
         ], 500);
       }
     }
     //update user
     function updateuser(Request $request)
     {
      try {
         $nom = $request->nom;
         $id = $request->id;
         $statUpd = Patient::where('id',$id)->update(['nom' => $nom]);
         if($statUpd==0)
         {
           return response()->json([
              'statuscode' =>404,
              'status'     =>false,
              'message'    =>'Aucun utilisateur',
              'user'       => ''
           ],404);
         }else{
           return response()->json([
              'statuscode' =>200,
              'status'     =>true,
              'message'    =>'mise à jour avec succès',
              'user'       => ''
           ],200);
         }
  
      } catch (\Throwable $th) {
         //throw $th;
         return response()->json([
            'statuscode'=>500,
            'status' => false,
            'message' => $th->getMessage()
         ], 500);
      }

     }
     //delete user
     function deletesuer(Request $request)
     {
      
       try {
         $id = $request->id;
         $res = Patient::destroy($id);

         if($res!=0) {
            return response()->json([
               'statuscode' =>200,
               'status'     =>true,
               'message'    =>'supprimer avec succès',
               'user'       => ''
            ],200);
         }else{
            return response()->json([
               'statuscode' =>404,
               'status'     =>false,
               'message'    =>'aucun utilisateur',
               'user'       => ''
            ],200);
         }

       } catch (\Throwable $th) {
         //throw $th;
         return response()->json([
            'statuscode'=>500,
            'status' => false,
            'message' => $th->getMessage()
         ], 500);
       }
     }


     //Exercice : 
     //Créer la table pharmacie avec les différentes attribut puis faites une opération de CRUD


}
