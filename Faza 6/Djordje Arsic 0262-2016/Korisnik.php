<?php namespace App\Controllers;

use App\Models\SastojakModel;
use App\Models\KoktelModel;
use App\Models\ObavezniModel;
use App\Models\NeobavezniModel; //sadrzi
use App\Models\RazlogModel;
use App\Models\PrijavaModel;
use App\Models\RazloziPrijaveModel;


class Korisnik extends BaseController { 
    
    private function provera() {
        if (!$this->session->get('korisnik')) {
            return redirect()->to(site_url('Pretraga'));
        }
    }
    
    public function index(){ 
       return redirect()->to(site_url('Pretraga'));
    }

    public function postaviRecept($poruka = null, $naziv = "", $opis="") {
        $this->provera();
        
        $sastojakModel=new SastojakModel();
        $sastojci = $sastojakModel->dohvatiImenaSastojaka();
        return $this->prikaz("postaviRecept", ['sastojci'=> $sastojci,
            'poruka'=>$poruka, 'naziv'=>$naziv, 'opis'=>$opis]);
    }
    
    public function receptSubmit() {
        $this->provera();
        
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
        
        $slika = $this->request->getFile('fotografija');
        $video = $this->request->getFile('video');
        
        // nema gresaka => napravi novi koktel    
        $idKorisnika = $this->session->get('korisnik')->idKorisnika;    
        $koktelData = [
            'idKorisnika' => $idKorisnika,
            'naziv' => $naziv,
            'opis' => $opis,
            'slika' => $slika->getName()!=="" ? $slika->getName(): NULL,
            'video' => $video->getName()!=="" ? $video->getName() : NULL,
            'obrisan' => 0,
            'datum' => "".date("Y-m-d").""
        ];

        $koktelModel = new KoktelModel();
        $idKoktela = $koktelModel->napraviNoviKoktel($koktelData);
        
        if($slika->getName()!=="") $slika->move(ROOTPATH.'/public/uploads/'.$idKoktela.'/');
        if ($video->getName()!=="") $video->move(ROOTPATH.'/public/uploads/'.$idKoktela.'/');
        
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
                   
    public function mojiKokteli(){
        $this->provera();
        $obavezniModel = new ObavezniModel();
        $neobavezniModel = new NeobavezniModel();
        $sastojakModel = new SastojakModel();
        $koktelModel = new KoktelModel();
        $kokteli=$koktelModel->receptiKorisnika($this->session->get('korisnik')->idKorisnika);
        $obavezniSastojciMojihKoktela = [];
        $neobavezniSastojciMojihKoktela = [];
        foreach($kokteli as $koktel){
            $sadrziObavezno = $obavezniModel->where('idKoktela',$koktel->idKoktela)->findall();
            $sadrziNeobavezno = $neobavezniModel->where('idKoktela',$koktel->idKoktela)->findall();
            $obaveznisastojci = array();
            $obaveznisastojci_kolicna = array();
            $neobaveznisastojci = array();
            $neobaveznisastojci_kolicna = array();
            foreach($sadrziObavezno as $so){
                $obavezansastojak = $sastojakModel->find($so->idSastojka);
                $obaveznisastojci[]= $obavezansastojak->naziv.' '.$so->kolicina;
            }
            foreach($sadrziNeobavezno as $sno){
                $neobavezansastojak = $sastojakModel->find($sno->idSastojka);
                $neobaveznisastojci[]= $neobavezansastojak->naziv.' '.$sno->kolicina;
            }
            $obavezniSastojciMojihKoktela[$koktel->idKoktela] = $obaveznisastojci;
            $neobavezniSastojciMojihKoktela[$koktel->idKoktela] = $neobaveznisastojci;
        }
        $this->prikaz('stranice/mojirecepti', ['kokteli'=>$kokteli,'obavezni_sastojci_mojih_koktela'=>$obavezniSastojciMojihKoktela,'neobavezni_sastojci_mojih_koktela'=>$neobavezniSastojciMojihKoktela]);
    }
    
    public function brisanjeMogRecepta(){
        $this->provera();
        
        $idKoktela = $this->request->getPost('idKoktela');
        $koktelModel = new KoktelModel();
        $korisnikId = $koktelModel->find($idKoktela)->idKorisnika;
        if($korisnikId==$this->session->get('korisnik')->idKorisnika){
            $koktelModel->set("obrisan",1)->where('idKoktela',$idKoktela)->update();
        }
        
        return redirect()->to(site_url('Korisnik/mojiKokteli'));
    }
    
//    public function test(){
//        $poruka='';
//        $registrovaniModel = new RegistrovaniModel();
//        $registrovani = $registrovaniModel->find(2);
//        $koktelModel = new KoktelModel();
//        $koktel = $koktelModel->find(2);
//        $razlogModel = new RazlogModel();
//        $razlozi = $razlogModel->findall();
//        $this->prikaz1('sablon/header_korisnik', 'stranice/tudjirecept', ['koktel' => $koktel,'razlozi' => $razlozi, 'registrovani'=>$registrovani, 'poruka'=>$poruka]);
//    }
    
    public function reportovanjeTudjegRecepta(){
            $this->provera();
            date_default_timezone_set('Europe/Belgrade');
            $datum = date('Y-m-d H:i:s');
            $idKoktela = $this->request->getPost('idKoktela');
            $idRegistrovanog = $this->session->get("korisnik")->idKorisnika;
            $razlogModel = new RazlogModel();
            $prijavaModel = new PrijavaModel();
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
                    if($razlog->idRazloga==3) $razlog_duplikat = 1;
                }
            }                                   
            $razloziPrijaveModel = new RazloziPrijaveModel();
            $prijavaModel->save(['idKoktela' => $idKoktela, 'idRegistrovanog' => $idRegistrovanog, 'datum' => $datum, 'obrisanaPrijava'=>0]);
            foreach($razloziprijave as $razlogprijave){
                if($razlogprijave==3){
                    $razloziPrijaveModel->save(['datum' => $datum, 'idKoktela' => $idKoktela, 'idRegistrovanog' => $idRegistrovanog, 'idRazloga' => $razlogprijave, 'duplikat'=> $duplikat]);
                    }
                    else{
                        $razloziPrijaveModel->save(['datum' => $datum, 'idKoktela' => $idKoktela, 'idRegistrovanog' => $idRegistrovanog, 'idRazloga' => $razlogprijave]);
                    }
                }
            
            return redirect()->to(site_url('Pretraga/koktel/'.$idKoktela));
    }
    
    public function mojKoktel($idKoktela){
        $this->provera();
        
        return redirect()->to(site_url('Pretraga/koktel/'.$idKoktela));
    }
}