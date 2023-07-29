<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
         $nom = $request->nom;
         return $nom;
      }
      //connection
      function loginPatient(Request $request)
      {
        return "connection patient";
      }
      //generer otp
      //verifier otp
}
