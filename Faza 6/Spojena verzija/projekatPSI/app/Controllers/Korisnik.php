<?php namespace App\Controllers;

use App\Models\SastojakModel;
use App\Models\KoktelModel;
use App\Models\ObavezniModel;
use App\Models\NeobavezniModel; //sadrzi
use App\Models\RazlogModel;
use App\Models\PrijavaModel;
use App\Models\RazloziPrijaveModel;
use App\Models\RegistrovaniModel;


class Korisnik extends BaseController
{    
    public function index(){
        $korisnik = $this->session->get('korisnik');
        return $this->prikaz("indexUlogovani", ['korisnik'=>$korisnik]);
    }

    public function postaviRecept($poruka = null, $naziv = "", $opis="") {   
        $sastojakModel=new SastojakModel();
        $sastojci = $sastojakModel->dohvatiImenaSastojaka();
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
        $sastojciBaza = $sastojakModel->dohvatiImenaSastojaka();
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
            if($kolicine[$sastojak]!=="") {
                $data = [
                    'idKoktela' => $idKoktela,
                    'idSastojka'  => $sastojakModel->dohvatiIdPoNazivu($sastojak),
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
       
    protected function prikaz1($header, $page, $data){
        echo view($header);
        echo view($page,$data);
        echo view("sablon/footer");
    }
    
    public function mojiKokteli(){
        $koktelModel = new KoktelModel();
        $kokteli=$koktelModel->receptiKorisnika('2');
        $this->prikaz1('sablon/header_korisnik','stranice/mojirecepti', ['kokteli'=>$kokteli]);
    }
    
    public function brisanjeMogRecepta($idKoktela){
        $koktelModel = new KoktelModel();
        $koktelModel->set("obrisan",1)->where('idKoktela',$idKoktela)->update();
        $this->mojiKokteli();
    }
    
    public function test(){
        $poruka='';
        $registrovaniModel = new RegistrovaniModel();
        $registrovani = $registrovaniModel->find(2);
        $koktelModel = new KoktelModel();
        $koktel = $koktelModel->find(2);
        $razlogModel = new RazlogModel();
        $razlozi = $razlogModel->findall();
        $this->prikaz1('sablon/header_korisnik', 'stranice/tudjirecept', ['koktel' => $koktel,'razlozi' => $razlozi, 'registrovani'=>$registrovani, 'poruka'=>$poruka]);
    }
    
    public function reportovanjeTudjegRecepta($idKoktela, $idRegistrovanog){
            $razlogModel = new RazlogModel();
			$prijavaModel = new PrijavaModel();
			$postoji_prijava = $prijavaModel->where('idRegistrovanog',$idRegistrovanog)->where('idKoktela',$idKoktela)->findall();
            $razlozi = $razlogModel->findall();
            $razloziprijave = array();
            $razlog_duplikat = 0;
            $duplikat = $this->request->getPost('original');
            $greska = 0;
            foreach($razlozi as $razlog){
                $ponuda = NULL;
                $ponuda = $this->request->getPost('r['.$razlog->opisRazloga.']');
                if(isset($ponuda)){
                    $razloziprijave[]=$razlog->idRazloga;
                    if($razlog->idRazloga==3) $razlog_duplikat =1;
                }
            }
            $poruka_prijave='';
            if(empty($razloziprijave)){
                $poruka_prijave= $poruka_prijave.'Morate uneti razlog prijave!<br/>';
                $greska=1;
            }
            if(($duplikat==NULL)&&($razlog_duplikat ==1)){
                $poruka_prijave= $poruka_prijave.'Morate uneti originalni recept ako tvrite da je ovaj recept duplikat!<br/>';
                $greska=1; 
            }
            if($greska==1){
                $registrovaniModel = new RegistrovaniModel();
                $koktelModel = new KoktelModel();
                $registrovani = $registrovaniModel->find($idRegistrovanog);
                $koktel = $koktelModel->find($idKoktela);
                $this->prikaz1('sablon/header_korisnik', 'stranice/tudjirecept', ['koktel' => $koktel,'razlozi' => $razlozi, 'registrovani'=>$registrovani, 'poruka'=>$poruka_prijave]);
            }
            else{
                $razloziPrijaveModel = new RazloziPrijaveModel();
                if($postoji_prijava==null){
                    $prijavaModel->save(['idKoktela' => $idKoktela, 'idRegistrovanog' => $idRegistrovanog, 'datum' => date('Y-m-d'), 'obrisanaPrijava'=>0]);
                }
                foreach($razloziprijave as $razlogprijave){
					$postoji_razlog = $razloziPrijaveModel->where('idRegistrovanog',$idRegistrovanog)->where('idKoktela',$idKoktela)->where('idRazloga',$razlogprijave)->findall();
                    if($postoji_razlog==null){
						if($razlogprijave==3){
                        $razloziPrijaveModel->insert(['idKoktela' => $idKoktela, 'idRegistrovanog' => $idRegistrovanog, 'idRazloga' => $razlogprijave, 'duplikat'=> $duplikat]);
						}
						else{
                        $razloziPrijaveModel->insert(['idKoktela' => $idKoktela, 'idRegistrovanog' => $idRegistrovanog, 'idRazloga' => $razlogprijave]);
						}
					}
                }
                echo view('sablon/header_korisnik');
                echo view('sablon/footer');
            }
    }
    
    public function mojKoktel($idKoktela){
        $koktelModel = new KoktelModel();
        $sadrziObaveznoModel = new ObavezniModel();
        $sadrziNeobaveznoModel = new NeobavezniModel();
        $sastojakModel= new SastojakModel();
        $sadrziObavezno = $sadrziObaveznoModel->where('idKoktela',$idKoktela)->findall();
        $sadrziNeobavezno = $sadrziNeobaveznoModel->where('idKoktela',$idKoktela)->findall();
        $obaveznisastojci = array();
        $obaveznisastojci_kolicna = array();
        $neobaveznisastojci = array();
        $neobaveznisastojci_kolicna = array();
        foreach($sadrziObavezno as $so){
            $obavezansastojak = $sastojakModel->find($so->idSastojka);
            $obaveznisastojci[]= $obavezansastojak->naziv;
            $obaveznisastojci_kolicna[]= $so->kolicina;
        }
        foreach($sadrziNeobavezno as $sno){
            $neobavezansastojak = $sastojakModel->find($sno->idSastojka);
            $neobaveznisastojci[]= $neobavezansastojak->naziv;
            $neobaveznisastojci_kolicna[]= $sno->kolicina;
        }
        $koktel = $koktelModel->find($idKoktela);
        $this->prikaz1('sablon/header_korisnik', 'stranice/mojrecept', ['koktel' => $koktel, 'obaveznisastojci'=> $obaveznisastojci, 'obaveznisastojci_kolicina'=>$obaveznisastojci_kolicna, 'neobaveznisastojci'=> $neobaveznisastojci, 'neobaveznisastojci_kolicina'=>$neobaveznisastojci_kolicna]);
    }
    
}