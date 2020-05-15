<?php namespace App\Controllers;

use App\Models\SastojakModel;
use App\Models\KoktelModel;
use App\Models\ObavezniModel;
use App\Models\NeobavezniModel;

class Korisnik extends BaseController
{
    
    public function index(){
        $korisnik = $this->session->get('korisnik');
        return $this->prikaz("indexUlogovani", ['korisnickoIme'=>$korisnik->username]);
    }

    public function postaviRecept($poruka = null, $naziv = "", $opis="") {   
        $sastojakModel=new SastojakModel();
        $sastojci = $sastojakModel->dohvatiSastojke();
        return $this->prikaz("postaviRecept", ['sastojci'=> $sastojci, 'poruka'=>$poruka, 'naziv'=>$naziv, 'opis'=>$opis]);
    }
    
    public function receptSubmit() {                
        $poruka="";
        
        // proverava da li je unet naslov       
        $naziv = $this->request->getPost('naziv');
        if(!$this->validate(['naziv'=>'required'])){
            $poruka.="Niste uneli naziv recepta.<br>";
        }
        
        // proverava da li je unet opis
        $opis = $this->request->getPost('opis');
        if(strlen($opis)==0){
            $poruka.="Niste uneli opis recepta.<br>";
        }
        
        $sastojakModel = new SastojakModel();
        $sastojciBaza = $sastojakModel->dohvatiSastojke();
        $kolicine = $this->request->getPost('kolicine'); // sastojci iz forme
        $neobavezniForma = $this->request->getPost('neobavezni');
        $flagObavezni=0; // oznacen bar 1 obavezan sastojak

        
        // proverava da li je korisnik uneo recept bez obaveznog sastojka
        foreach($sastojciBaza as $sastojak) {   
            if($kolicine[$sastojak]!="" && ($neobavezniForma==0 || !in_array($sastojak, $neobavezniForma))) {               
                $flagObavezni = 1;
                break;                
            }
        }       
        if($flagObavezni==0) {
            $poruka.="Niste uneli nijedan obavezan sastojak.";
        }
        if($poruka!="") {
            return $this->postaviRecept($poruka, $naziv, $opis);
        }
        
        
        // nema gresaka => napravi novi koktel    
        $idKorisnika = $this->session->get('korisnik')->idKorisnika;    
        $koktelData = [
            'idKorisnika' => $idKorisnika,
            'naziv' => $naziv,
            'opis' => $opis,
            'slika' => null,
            'video' => null,
            'obrisan' => 0,
            'datum' => "".date("Y-m-d").""
        ];

        $koktelModel = new KoktelModel();
        $idKoktela = $koktelModel->napraviNoviKoktel($koktelData);
        
        $obavezniModel = new ObavezniModel();
        $neobavezniModel = new NeobavezniModel();
        
        foreach($sastojciBaza as $sastojak) {   
            if($kolicine[$sastojak] > 0) {
                $data = [
                    'idKoktela' => $idKoktela,
                    'idSastojka'  => $sastojakModel->dohvatiId($sastojak),
                    'kolicina'  => $kolicine[$sastojak]
                ];
                if($neobavezniForma!=0 && in_array($sastojak, $neobavezniForma)) {
                    $neobavezniModel->insert($data);
                }
                else {
                    $obavezniModel->insert($data);
                }
            }
        }
                
        return redirect()->to(site_url('Korisnik'));
    }
    
    public function logOut() {
        $this->session->destroy();
        return redirect()->to(site_url('/'));
    }
    
    public function register($poruka=null) {
        $this->prikaz('register', ['poruka'=>$poruka]);

    }
}