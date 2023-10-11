<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//Importer les controller
use App\Http\Controllers\PatientController;
use App\Http\Controllers\PharmacieController;
use App\Http\Controllers\LivreurController;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
   return $request->user();
});

/**
 * ----------------------
 *  API AFYA ENDPOINTS
 *    AFYAAPI v1
 * ----------------------
 */

   /**
    *---------------
    * API PATIENT
    *---------------
    */
      /**
       * ------------------
       *  AUTHENTIFICATION
       * -----------------
       */
          //inscription
          Route::match(['GET','POST'],'inscriptionPatient',[PatientController::class, 'inscriptionPatient']);
          //connection
          Route::match(['GET','POST'],'loginPatient',[PatientController::class, 'loginPatient']);
          //generate OTP
          route::match (["GET","POST"],"generateOtp",[patientcontroller::class,"generateOtp"]);
          //Check OTP
          route::match (["GET","POST"],"checkOtp",[patientcontroller::class,"checkOtp"]);
      
      /**
       * ----------
       *  COMPTE
       * ----------
       */
          route::match (["GET","POST"],"getPatientCount",[patientcontroller::class,"getPatientCount"]);
          route::match (["PUT","POST"],"updatePatientCount",[patientcontroller::class,"updatePatientCount"]);

      /**
       * ------------
       *  ORDONNANCE
       * ------------
       */
          route::match (["GET","POST"],"sendOrdonnance",[patientcontroller::class,"sendOrdonnance"]);
          route::match (["GET","POST"],"getAllOrdonnance",[patientcontroller::class,"getAllOrdonnance"]);
          route::match (["GET","POST"],"getOrdonnanceByStatus",[patientcontroller::class,"getOrdonnanceByStatus"]);
          route::match (["GET","POST"],"updateOrdonStatus",[patientcontroller::class,"updateOrdonStatus"]);
          route::match (["GET","POST"],"getOneOrdonById",[patientcontroller::class,"getOneOrdonById"]);
        
      /**
       * ----------------
       *  FACTURE
       * ----------------
       */
          route::match (["GET","POST"],"payFacture",[patientcontroller::class,"payFacture"]);
          route::match (["GET","POST"],"getFacture",[patientcontroller::class,"getFacture"]);
          route::match (["GET","POST"],"getFactureId",[patientcontroller::class,"getFactureId"]);
          route::match (["GET","POST"],"getFactureStatus",[patientcontroller::class,"getFactureStatus"]);

      /**
       * ----------------
       *  PHARMACIE
       * ----------------
       */
          route::match (["GET","POST"],"getPharmacieId",[patientcontroller::class,"getPharmacieId"]);
          route::match (["GET","POST"],"pharmacie",[patientcontroller::class,"pharmacie"]);
          route::match (["GET","POST"],"pharmacieStatus",[patientcontroller::class,"pharmacieStatus"]);
          route::match (["GET","POST"],"pharmacieGarde",[patientcontroller::class,"pharmacieGarde"]);


    

    
          /**
    *---------------
    * API PHARMACIE
    *---------------
    */

      /**
       * -------------------
       * AUTHENTIFICATION
       * -------------------
       */
          route:: match (["GET","POST"],"inscriptionpharmacie",[pharmaciecontroller::class,"inscriptionpharmacie"]);
          route:: match (["GET","POST"],"loginPharmacie",[pharmaciecontroller::class,"loginPharmacie"]);
          route:: match (["GET","POST"],"pharmacieOtp",[pharmaciecontroller::class,"pharmacieOtp"]);
          route:: match (["GET","POST"],"checkpharmacieOtp",[pharmaciecontroller::class,"checkpharmacieOtp"]);

      /**
       * -------------------
       * COMPTE
       * -------------------
       */
          route:: match (["GET","POST"],"pharmacieCount",[pharmaciecontroller::class,"pharmacieCount"])->middleware('auth:sanctum');
          route:: match (["PUT","POST"],"updatePharmacieCount",[pharmaciecontroller::class,"updatePharmacieCount"])->middleware('auth:sanctum');

      /**
       * -------------------
       * ORDONNANCE
       * -------------------
       */
          route:: match (["GET","POST"],"getPharmacieOrdon",[pharmaciecontroller::class,"getPharmacieOrdon"]);
          route:: match (["GET","POST"],"getPharmacieOrdonStatus",[pharmaciecontroller::class,"getPharmacieOrdonStatus"]);
          route:: match (["PUT","POST"],"updatePharmacieOrdonStatus",[pharmaciecontroller::class,"updatePharmacieOrdonStatus"]);
          route:: match (["GET","POST"],"getPharmacieOrdonId",[pharmaciecontroller::class,"getPharmacieOrdonId"]);
          route:: match (["GET","POST"],"posologieduneordonnance",[pharmaciecontroller::class,"posologieduneordonnance"]);


      /**
       * -------------------
       * FACTURE
       * -------------------
       */
          route:: match (["GET","POST"],"sendFacture",[pharmaciecontroller::class,"sendFacture"]);
          route:: match (["GET","POST"],"getPharmcieFacture",[pharmaciecontroller::class,"getPharmcieFacture"]);
          route:: match (["GET","POST"],"getPharmacieFactureId",[pharmaciecontroller::class,"getPharmacieFactureId"]);
          route:: match (["GET","POST"],"getFactureStatus",[pharmaciecontroller::class,"getFactureStatus"]);



    /**
    *---------------
    * API LIVREUR
    *---------------
    */
      /**
       * -------------------
       * AUTHENTIFICATION
       * -------------------
       */
          route:: match (["GET","POST"],"inscriptionlivreur",[livreurcontroller::class,"inscriptionlivreur"]);
          route:: match (["GET","POST"],"loginLivreur",[livreurcontroller::class,"loginLivreur"]);
          route:: match (["GET","POST"],"generateOTP",[livreurcontroller::class,"generateOTP"]);
          route:: match (["GET","POST"],"checkOTP",[livreurcontroller::class,"checkOTP"]);
          route:: match (["GET","POST"],"newPassword",[livreurcontroller::class,"newPassword"]);


      /**
       * -------------------
       * COMPTE
       * -------------------
       */  

          route:: match (["GET","POST"],"getLivreurCount",[livreurcontroller::class,"getLivreurCount"])->middleware('auth:sanctum');
          route:: match (["PUT","POST"],"updateLivreurCount",[livreurcontroller::class,"updateLivreurCount"])->middleware('auth:sanctum');

      /**
       * -------------------
       * ORDONNANCE
       * -------------------
       */
          route:: match (["GET","POST"],"getallordonnance",[livreurcontroller::class,"getallordonnance"]);
          route:: match (["GET","POST"],"getordonnancebystatus",[livreurcontroller::class,"getordonnancebystatus"]);
          route:: match (["GET","POST"],"getordonnancebyid",[livreurcontroller::class,"getordonnancebyid"]);


    /**
    *---------------
    * API ADMIN
    *---------------
    */

      /**
       * ---------------
       * AUTHENTICATION
       * ---------------
       */
          route:: match (["GET","POST"],"inscriptionAdmin",[admincontroller::class,"inscriptionAdmin"]);
          route:: match (["GET","POST"],"connectionAdmin",[admincontroller::class,"connectionAdmin"]);
          route:: match (["GET","POST"],"generateOTP",[admincontroller::class,"generateOTP"]);
          route:: match (["GET","POST"],"checkOTP",[admincontroller::class,"checkOTP"]);
          route:: match (["GET","POST"],"newPassword",[admincontroller::class,"newPassword"]);


      /**
       * ------------
       * COMPTE
       * ------------
       */
          route:: match (["GET","POST"],"getAdmincount",[admincontroller::class,"getAdmincount"]);
          route:: match (["PUT","POST"],"updateAdmincount",[admincontroller::class,"updateAdmincount"]);

      /**
       * -------------------
       * SUPERVISEUR
       * -------------------
       */
          route:: match (["GET","POST"],"ajouterunsuperviseur",[admincontroller::class,"ajouterunsuperviseur"]);
          route:: match (["GET","POST"],"Getallsuperviseurs",[admincontroller::class,"Getallsuperviseurs"]);
          route:: match (["GET","POST"],"superviseurbyid",[admincontroller::class,"superviseurbyid"]);
          route:: match (["GET","POST"],"Superviseurbystatus",[admincontroller::class,"Superviseurbystatus"]);
          route:: match (["GET","POST"],"updatesuperviseurstatus",[admincontroller::class,"updatesuperviseurstatus"]);
   


      /**
       * -------------------
       * ZONE DE SUPERVISION
       * -------------------
       */
          route:: match (["GET","POST"],"ajouterunezone",[admincontroller::class,"ajouterunezone"]);
          route:: match (["GET","POST"],"getonezonebyid",[admincontroller::class,"getonezonebyid"]);
          route:: match (["GET","POST"],"getallzone",[admincontroller::class,"getallzone"]);
          route:: match (["PUT","POST"],"updateonzone",[admincontroller::class,"updateonzone"]);

      /**
       * -------------------
       * GESTIONNAIRE
       * -------------------
       */
          route:: match (["GET","POST"],"sendgestionnaire",[admincontroller::class,"sendgestionnaire"]);
          route:: match (["GET","POST"],"getallGestionnaire",[admincontroller::class,"getallGestionnaire"]);
          route:: match (["PUT","POST"],"updategestionnaire",[admincontroller::class,"updategestionnaire"]);
          route:: match (["GET","POST"],"gestionnairebyid",[admincontroller::class,"gestionnairebyid"]);
   

      /**
       * -------------------
       * LIVREUR
       * -------------------
       */
          route:: match (["GET","POST"],"ajouerunlivreur",[admincontroller::class,"ajouerunlivreur"]);
          route:: match (["GET","POST"],"getonelivreurbyid",[admincontroller::class,"getonelivreurbyid"]);
          route:: match (["PUT","POST"],"updateonelivreur",[admincontroller::class,"updateonelivreur"]);
          route:: match (["GET","POST"],"getalllivreur",[admincontroller::class,"getalllivreur"]);
          route:: match (["GET","POST"],"getalllivreurbystatus",[admincontroller::class,"getalllivreurbystatus"]);
         

      /**
       * -------------------
       * PHARMACIE
       * -------------------
       */
          route:: match (["GET","POST"],"ajouterunepharmacie",[admincontroller::class,"ajouterunepharmacie"]);
          route:: match (["PUT","POST"],"updateonepharmacie",[admincontroller::class,"updateonepharmacie"]);
          route:: match (["GET","POST"],"getallpharmacie",[admincontroller::class,"getallpharmacie"]);
          route:: match (["GET","POST"],"getonepharmacie",[admincontroller::class,"getonepharmacie"]);
          route:: match (["GET","POST"],"getallpharmaciebystatus",[admincontroller::class,"getallpharmaciebystatus"]);
          route:: match (["GET","POST"],"updatepharmaciestatus",[admincontroller::class,"updatepharmaciestatus"]);
          route:: match (["GET","POST"],"getallpharmaciebyzone",[admincontroller::class,"getallpharmaciebyzone"]);

      /**
       * -------------------
       * PATIENT
       * -------------------
       */
          route:: match (["GET","POST"],"getallpatients",[admincontroller::class,"getallpatients"]);
          route:: match (["GET","POST"],"getonepatient",[admincontroller::class,"getonepatient"]);
          route:: match (["PUT","POST"],"updateonepatient",[admincontroller::class,"updateonepatient"]);
          route:: match (["GET","POST"],"lockonepatient",[admincontroller::class,"lockonepatient"]);

   
   