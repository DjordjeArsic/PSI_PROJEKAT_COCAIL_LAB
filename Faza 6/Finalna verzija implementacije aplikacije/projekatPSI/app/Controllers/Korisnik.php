<?php namespace App\Controllers;

use App\Models\SastojakModel;
use App\Models\KoktelModel;
use App\Models\ObavezniModel;
use App\Models\NeobavezniModel;
use App\Models\RazlogModel;
use App\Models\PrijavaModel;
use App\Models\RazloziPrijaveModel;
use App\Models\KorisnikModel;
use App\Models\RegistrovaniModel;

// Korisnik kontroler - klasa za upravljanje akcijama koje su namenjene ulogovanom korisniku
// Autori: Djordje Arsic - 2016/0262, Marko Stankovic - 2017/0331 i Stefan Radenkovic 2017/0573
// @verzija 1.0
class Korisnik extends BaseController { 
    // provera da li je u pitanju zaista ulogovani korisnik
    // rezultat: false za nedozvoljeni, true za dozvoljeni ulaz na stranicu
    private function provera() {
        $korisnik = $this->session->get('korisnik');
        
        // da li je korisnik uopste ulogovan
        if ($korisnik == NULL) {
            return false;
        }
        
        // da li je korisnik obrisan u medjuvremenu          
        if(!$korisnik->isAdmin) {
            $registrovaniModel = new RegistrovaniModel();
            $korisnikBaza = $registrovaniModel->find($korisnik->idKorisnika);
            
            if($korisnikBaza->obrisanNalog) {
                return false;
            }
        }
              
        return true;
    }
    
    // rezultat: redirect na stranicu za pretragu
    public function index(){ 
       if(!$this->provera()) { return redirect()->to(site_url('Nalog/logOut')); }
       return redirect()->to(site_url('Pretraga'));
    }

    // rezultat: prikazuje stranicu za dodavanje novog recepta
    public function postaviRecept($poruka = null, $naziv = "", $opis="") {
        if(!$this->provera()) { return redirect()->to(site_url('Nalog/logOut')); }
        
        $sastojakModel=new SastojakModel();
        $sastojci = $sastojakModel->dohvatiImenaSastojaka();
        return $this->prikaz("postaviRecept", ['sastojci'=> $sastojci,
            'poruka'=>$poruka, 'naziv'=>$naziv, 'opis'=>$opis]);
    }
    
    // metoda koja se poziva kada se klikne na postavljanje recepta
    // rezultat: u slucaju greske ispisuje se poruka, inace se dodaje novi koktel u BP i
    // redirectuje se na stranicu Moji Recepti
    public function receptSubmit() {
        if(!$this->provera()) { return redirect()->to(site_url('Nalog/logOut')); }
        
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
        
        date_default_timezone_set("Europe/Belgrade");
        
        // nema gresaka => napravi novi koktel    
        $idKorisnika = $this->session->get('korisnik')->idKorisnika;    
        $koktelData = [
            'idKorisnika' => $idKorisnika,
            'naziv' => $naziv,
            'opis' => $opis,
            'slika' => $slika->getName()!=="" ? $slika->getName(): NULL,
            'video' => $video->getName()!=="" ? $video->getName() : NULL,
            'obrisan' => 0,
            'datum' => date('Y-m-d H:i:s')
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
        if(!$this->provera()) { return redirect()->to(site_url('Nalog/logOut')); }
       
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
            $obaveznisastojci = [];
            $neobaveznisastojci = [];
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
        $this->prikaz('mojirecepti', ['kokteli'=>$kokteli,'obavezni_sastojci_mojih_koktela'=>$obavezniSastojciMojihKoktela,'neobavezni_sastojci_mojih_koktela'=>$neobavezniSastojciMojihKoktela]);
    }
    
    // funkcija koja postavlja indikator obrisan na 1 u bp za recept
    // takodje brisu se sve prijave za taj recept
    // rezultat: redirect na stranicu Moji Kokteli
    public function brisanjeMogRecepta(){
        if(!$this->provera()) { return redirect()->to(site_url('Nalog/logOut')); }
        
        $idKoktela = $this->request->getPost('idKoktela');
        $koktelModel = new KoktelModel();
        $korisnikId = $koktelModel->find($idKoktela)->idKorisnika;
        if($korisnikId==$this->session->get('korisnik')->idKorisnika){
            $prijavaModel = new PrijavaModel();
            $prijaveOvogrecepta= $prijavaModel->where("idKoktela",$idKoktela)->findall();
            foreach($prijaveOvogrecepta as $prijava){
                $prijavaModel->set("obrisanaPrijava", 1)->where("idKoktela",$idKoktela)->update();
            }
            $koktelModel->set("obrisan",1)->where('idKoktela',$idKoktela)->update();
        }
        
        return redirect()->to(site_url('Korisnik/mojiKokteli'));
    }
    
    // metoda za prijavu tudjeg recepta, dodaje se u bp nova prijava za dati recept
    // kao i poslati razlozi prijave
    // rezultat: redirect na stranicu recepta za koji je podneta prijava
    public function reportovanjeTudjegRecepta(){
            if(!$this->provera()) { return redirect()->to(site_url('Nalog/logOut')); }
        
            $idKoktela = $this->request->getPost('idKoktela');
            $idRegistrovanog = $this->session->get("korisnik")->idKorisnika;
            
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
                    if($razlog->idRazloga==3) $razlog_duplikat = 1;
                }
            }                                   
            $razloziPrijaveModel = new RazloziPrijaveModel();
            if($postoji_prijava==null){
                $prijavaModel->save(['idKoktela' => $idKoktela, 'idRegistrovanog' => $idRegistrovanog, 'datum' => date('Y-m-d'), 'obrisanaPrijava'=>0]);
            }
            foreach($razloziprijave as $razlogprijave){
                $postoji_razlog = $razloziPrijaveModel->where('idRegistrovanog',$idRegistrovanog)->where('idKoktela',$idKoktela)->where('idRazloga',$razlogprijave)->findall();
                if($postoji_razlog==null){
                    if($razlogprijave==3){
                        $razloziPrijaveModel->save(['idKoktela' => $idKoktela, 'idRegistrovanog' => $idRegistrovanog, 'idRazloga' => $razlogprijave, 'duplikat'=> $duplikat]);
                    }
                    else{
                        $razloziPrijaveModel->save(['idKoktela' => $idKoktela, 'idRegistrovanog' => $idRegistrovanog, 'idRazloga' => $razlogprijave]);
                    }
                }
            }
            
            return redirect()->to(site_url('Pretraga/koktel/'.$idKoktela));
    }
    
    // metod koji proverava da li uneti email vec postoji u bazi (AJAX)
    public function ProveriEmail()
   {
        $email= $_POST['email'];
        
        
        
        // provera da li e-mail u odgovarajucem formatu
        $re = "/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/";
        if(! preg_match($re, $email)) {
            echo 2; return; // los oblik email-a
        } 
        
        $korisnikModel = new KorisnikModel();

        $where = "email REGEXP BINARY '$email'";
        
        $result = $korisnikModel->where($where)->where('email', $email)->findall();
        if(count($result) != 0)
        {
            echo  1;	// email vec postoji
        }
        else
        {
            echo  0;	// email ne postoji
        }
    }
    
    // metod koji proverava da li uneti username vec postoji u bazi (AJAX)
    public function ProveriUsername()
   {
        $username= $_POST['username'];
        $korisnikModel = new KorisnikModel();

        $where = "username REGEXP BINARY '$username'";
        
        $result = $korisnikModel->where($where)->where('username', $username)->findall();
        if(count($result) != 0)
        {
            echo  1;	// username vec postoji
        }
        else
        {
            echo  0;	// username ne postoji
        }
    }
}