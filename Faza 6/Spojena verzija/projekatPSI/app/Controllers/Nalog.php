<?php namespace App\Controllers;

use App\Models\KorisnikModel;
use App\Models\RegistrovaniModel;
use App\Models\AdminModel;

class Nalog extends BaseController {
    public function login($poruka=null){
        $this->prikaz('login', ['poruka'=>$poruka]);
    }
           
    public function loginSubmit(){
        $poruka = "";
        $korime = $this->request->getPost('korime');
        $lozinka = $this->request->getPost('lozinka');
        if($korime===""){
            $poruka.='Niste uneli korisnicko ime.<br>';
        }
        if($lozinka===""){
            $poruka.="Niste uneli lozinku.<br>";
        }
        
        if($poruka!="") {
            return $this->login($poruka);
        }
        
        $korisnikModel=new KorisnikModel();
        $korisnik=$korisnikModel->dohvatiKorisnikaPoImenu($korime);
        if($korisnik==null || $korisnik->password!=$lozinka) {
            return $this->login('Pogresno korisnicko ime i/ili lozinka. Molimo pokusajte ponovo.<br>');
        }
             
        $adminModel = new AdminModel();
        $isAdmin=$adminModel->proveraDaLiJeAdmin($korisnik->idKorisnika);
        
        if (!$isAdmin) {
            $registrovaniModel=new RegistrovaniModel();
            if($registrovaniModel->isObrisan($korisnik->idKorisnika)) {
                return $this->login('Ovaj nalog je obrisan.<br>');
            }
        }
        
        // pamtimo idKorisnika, username i da li je admin
        
        $this->session->set('korisnik', (object)['idKorisnika'=>$korisnik->idKorisnika,
                                         'username'=>$korisnik->username,
                                         'isAdmin'=>$isAdmin]);
        
        if ($isAdmin) {
            return redirect()->to(site_url('Admin'));
        } else {      
            return redirect()->to(site_url('Korisnik'));
        }

    }
    
    public function logOut() {
        $this->session->destroy();
        return redirect()->to(site_url('/'));
    }
    
    public function register($poruka=null) {
        $this->prikaz('register', ['poruka'=>$poruka]);
    }
    
    public function registerSubmit() {
        
        $data['username'] = $this->request->getPost('korime');
        $data['password'] = $this->request->getPost('lozinka');
        $data['email'] = $this->request->getPost('email');
                
        //todo: proveri e-mail, username, sifru, da li se sifre slazu
        //da li vec postoji korisnik sa tim imenom
        //da li vec postoji korisnik sa tim e-mailom
        
        $korisnikModel=new KorisnikModel();
        $idKorisnika = $korisnikModel->dodajNovogKorisnika($data);        
        $data2['idRegistrovanog'] = $idKorisnika;
        $data2['obrisanNalog'] = 0;
        $registrovaniModel=new RegistrovaniModel();
        $registrovaniModel->insert($data2);
        
        $korisnik=$korisnikModel->dohvatiKorisnikaPoImenu($data['username']);
        $this->session->set('korisnik', $korisnik);
        
        return redirect()->to(site_url('Korisnik'));
    }
}
