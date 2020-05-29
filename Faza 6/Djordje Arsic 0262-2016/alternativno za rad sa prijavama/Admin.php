<?php namespace App\Controllers;
use App\Models\KoktelModel;
use App\Models\RegistrovaniModel;
use App\Models\PrijavaModel;
use App\Models\RazlogModel;
use App\Models\RazloziPrijaveModel;

// Admin kontroler - klasa za upravljanje akcijama koje su namenjene adminu
// Autor: Stefan Radenkovic - 2017/0573
// @verzija 1.0
class Admin extends Korisnik {   
    // proverava da li je korisnik ulogovan i da li je admin
    // rezultat redirect na odgovarajucu stranicu u slucaju da nije admin
    private function provera() {
        if (!$this->session->get('korisnik')) {
            return redirect()->to(site_url('Pretraga'));
        }
        if (!$this->session->get('korisnik')->isAdmin) {
            return redirect()->to(site_url('Pretraga'));
        }
    }
    
    // postavlja indikator obrisan na 1 u bazi podataka za dati recept
    // takodje brise sve prijave vezane za ovaj koktel
    // rezultat redirect na reportovane recepte
    public function brisanjeRecepta($idKoktela){
        $this->provera();
        
        //Obrisi koktel
        $koktelModel = new KoktelModel();
        $koktelModel->set("obrisan",1)->where('idKoktela',$idKoktela)->update();
        
        //Obrisi sve prijave za koktel
        $prijavaModel = new PrijavaModel();
        $prijavaModel->set("obrisanaPrijava", 1)->where('idKoktela', $idKoktela)->update();
        
        return redirect()->to(site_url('Admin/reportovaniRecepti'));
    }
    
    // postavlja indikator obrisan na 1 u bazi podataka za datog korisnika
    // takodje brise sve njegove koktele i prijave za te koktele
    // rezultat redirect na reportovane recepte
    public function brisanjeKorisnika($idRegistrovanog){ 
        $this->provera();
        
        //Admin ne sme da se obrise
        if($idRegistrovanog == 1){ return redirect()->to(site_url('Admin/reportovaniRecepti')); }
        
        //Obrisi korisnika
        $registrovaniModel = new RegistrovaniModel();
        $registrovaniModel->set("obrisanNalog",1)->where('idRegistrovanog', $idRegistrovanog)->update();
        
        //Obrisi sve koktele korisnika
        $koktelModel = new KoktelModel();
        $koktelModel->set("obrisan",1)->where('idKorisnika', $idRegistrovanog)->update();
        
        //Obrisi sve prijave za koktele korisnika
        $prijavaModel = new PrijavaModel();
        $prijavaModel->set("obrisanaPrijava", 1)->where('idRegistrovanog', $idRegistrovanog)->update();
        
        return redirect()->to(site_url('Admin/reportovaniRecepti')); 
    }
    
    // postavlja indikator obrisan na 1 u bazi podataka za datu prijavu
    // rezultat redirect na reportovane recepte
    public function brisanjePrijave($idKoktela, $idRegistrovanog,$datum) {
        $datum2 = $this->request->getPost("datum2");
        $this->provera();
        $prijavaModel = new PrijavaModel();
        $prijavaModel->set("obrisanaPrijava", 1)->where('idKoktela', $idKoktela)->where('datum',$datum2)
                ->where('idRegistrovanog', $idRegistrovanog)->update(); 
        return redirect()->to(site_url('Admin/reportovaniRecepti')); 
    }
    
    // salje view-u sve prijavljene recepte
    // rezultat prikaz stranice prijavljeni recepti
    public function reportovaniRecepti() {
        $this->provera();
        
        //Dohvati sve prijave
        $prijavaModel = new PrijavaModel();
        $prijave = $prijavaModel->findAll();
        
        //Dohvati sve razloge
        $razlogModel = new RazlogModel();
        $razlozi = $razlogModel->findAll();
        
        $opisiRazloga = [];
        foreach($razlozi as $razlog)
        {
            $opisiRazloga[$razlog->idRazloga] = $razlog->opisRazloga;
        }
        
        $razloziPrijaveModel = new RazloziPrijaveModel();
        
        foreach($prijave as $key=>$prijava)
        {
            $prijava = (array) $prijava;
            $prijava["razlozi"] = $razloziPrijaveModel->where("datum", $prijava['datum'])->where("idKoktela", $prijava["idKoktela"])->where("idRegistrovanog", $prijava["idRegistrovanog"])->findAll();
            $prijava = (object) $prijava;
            $prijave[$key] = $prijava;
        }
        
        $this->prikaz('prijavljenirecepti' ,['prijave'=>$prijave, 'razlozi'=>$opisiRazloga,]); 
    }
}
