<?php namespace App\Controllers;
use App\Models\KoktelModel;
use App\Models\RegistrovaniModel;
use App\Models\PrijavaModel;
use App\Models\RazlogModel;
use App\Models\RazloziPrijaveModel;

class Admin extends Korisnik {   
    
    private function provera() {
        if (!$this->session->get('korisnik')) {
            return redirect()->to(site_url('Pretraga'));
        }
        if (!$this->session->get('korisnik')->isAdmin) {
            return redirect()->to(site_url('Pretraga'));
        }
    }
    
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
    
    public function brisanjePrijave($idKoktela, $idRegistrovanog) {
        $this->provera();
        
        $prijavaModel = new PrijavaModel();
        $prijavaModel->set("obrisanaPrijava", 1)->where('idKoktela', $idKoktela)->where('idRegistrovanog', $idRegistrovanog)->update(); 
        return redirect()->to(site_url('Admin/reportovaniRecepti')); 
    }
    
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
            $prijava["razlozi"] = $razloziPrijaveModel->where("idKoktela", $prijava["idKoktela"])->where("idRegistrovanog", $prijava["idRegistrovanog"])->findAll();
            $prijava = (object) $prijava;
            $prijave[$key] = $prijava;
        }
        
        $this->prikaz('stranice/prijavljenirecepti' ,['prijave'=>$prijave, 'razlozi'=>$opisiRazloga]); 
    }
}
