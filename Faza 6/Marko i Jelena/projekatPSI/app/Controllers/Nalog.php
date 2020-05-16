<?php namespace App\Controllers;

use App\Models\KorisnikModel;
use App\Models\RegistrovaniModel;
use App\Models\AdminModel;

class Nalog extends BaseController
{
    
    public function login($poruka=null){
        $this->prikaz('login', ['poruka'=>$poruka]);
    }
           
    public function loginSubmit(){
        $poruka="";
        if(!$this->validate(['korime'=>'required'])){
            $poruka.='Niste uneli korisnicko ime.<br>';
        }
        if(!$this->validate(['lozinka'=>'required'])){
            $poruka.="Niste uneli lozinku.";
        }
        if($poruka!="") {
            return $this->login($poruka);
        }
        
        $korisnikModel=new KorisnikModel();
        $korisnik=$korisnikModel->dohvatiKorisnikaPoImenu($this->request->getPost('korime'));
        if($korisnik==null || $korisnik->password!=$this->request->getPost('lozinka')) {
            return $this->login('Pogresno korisnicko ime i/ili lozinka. Molimo pokusajte ponovo.');
        }
        
        // pamtimo idKorisnika, username i da li je admin
        $adminModel = new AdminModel();
        $isAdmin=$adminModel->proveraDaLiJeAdmin($korisnik->idKorisnika);
        $this->session->set('korisnik', ['idKorisnika'=>$korisnik->idKorisnika,
                                         'username'=>$korisnik->username,
                                         'isAdmin'=>$isAdmin]);
        
        return redirect()->to(site_url('Korisnik'));
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
        
        $korisnikModel=new KorisnikModel();
        $data2['idRegistrovanog'] = $korisnikModel->dodajNovogKorisnika($data);
        $data2['obrisanNalog'] = 0;
        $registrovaniModel=new RegistrovaniModel();
        $registrovaniModel->insert($data2);
        
        $korisnik=$korisnikModel->dohvatiKorisnikaPoImenu($data['username']);
        $this->session->set('korisnik', $korisnik);
        
        return redirect()->to(site_url('Korisnik'));
    }
}
