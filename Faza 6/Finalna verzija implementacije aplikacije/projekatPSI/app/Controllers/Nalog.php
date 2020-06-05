<?php namespace App\Controllers;

use App\Models\KorisnikModel;
use App\Models\RegistrovaniModel;
use App\Models\AdminModel;



// Nalog kontroler - klasa za upravljanje akcijama kao sto su login, logout i registracija
// Autor: Jelena Dragojevic - 2017/0440, Marko Stankovic - 2017/0331
// @verzija 1.0
class Nalog extends BaseController {
    // provera da li je u pitanju zaista gost korisnik
    // rezultat: false za nedozvoljeni, true za dozvoljeni ulaz na stranicu
    private function provera() {
        return $this->session->get('korisnik') == NULL ? true : false;
    }
    
    // rezultat: prikaz stranice za login
    public function login($poruka=null){
        if(!$this->provera()) { return redirect()->to(site_url('Pretraga')); }
        
        $this->prikaz('login', ['poruka'=>$poruka]);       
    }
           
    // obrada zahteva za login
    // rezultat: redirect na stranicu korisnika (uspesan login) ili
    // ispis greske
    public function loginSubmit(){
        if(!$this->provera()) { return redirect()->to(site_url('Pretraga')); }
        
        $poruka = "";
        $korime = $this->request->getPost('korime');
        $lozinka = $this->request->getPost('lozinka');
        if($korime==""){
            $poruka.='Niste uneli korisničko ime!<br>';
        }
        if($lozinka==""){
            $poruka.="Niste uneli lozinku!<br>";
        }
        
        if($poruka!="") {
            return $this->login($poruka);
        }
        
        $korisnikModel=new KorisnikModel();
        $korisnik=$korisnikModel->dohvatiKorisnikaPoImenu($korime);
        if($korisnik==null || $korisnik->username!=$korime || $korisnik->password!=$lozinka) {
            return $this->login('Pogrešno korisničko ime i/ili lozinka. Molimo pokušajte ponovo.<br>');
        }
             
        $adminModel = new AdminModel();
        $isAdmin=$adminModel->proveraDaLiJeAdmin($korisnik->idKorisnika);
        
        if (!$isAdmin) {
            $registrovaniModel=new RegistrovaniModel();
            if($registrovaniModel->isObrisan($korisnik->idKorisnika)) {
                return $this->login('Ovaj nalog je obrisan!<br>');
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
    
    // logout - brisu se sacuvane sesije i redirectuje se na pocetnu stranicu gosta
    public function logOut() {
        $this->session->destroy();
        return redirect()->to(site_url('Pretraga'));
    }
    
    // rezultat: prikaz stranice za registraciju
    public function register($poruka=null) {
        if(!$this->provera()) { return redirect()->to(site_url('Pretraga')); }
        
        $this->prikaz('register', ['poruka'=>$poruka]);
    }
    
    // obrada zahteva za registraciju
    // rezultat: redirect na pocetnu stranicu korisnika ili
    // ispis greske 
    public function registerSubmit() {     
        if(!$this->provera()) { return redirect()->to(site_url('Pretraga')); }
        
        $data['username'] = $this->request->getPost('korime');        
        $data['email'] = $this->request->getPost('email');
        $data['password'] = $this->request->getPost('lozinka');
        $data['passwordRep'] = $this->request->getPost('ponovljenaLozinka');
           
        
        $poruka = "";
        $korisnikModel=new KorisnikModel();
        
        
        // provera da li je korisnicko ime uneto
        if($data['username']=="") {
            $poruka .= "Nije uneto korisničko ime!<br>";
        }
        // ako jeste da li postoji vec registrovani korisnik sa tim imenom
        else if ($korisnikModel->dohvatiKorisnikaPoImenu($data['username'])) {
            $poruka .= "Već postoji registrovani korisnik sa tim korisničkim imenom!<br>";
        }
        

        $re = "/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/";
        // provera da li e-mail u odgovarajucem formatu
        if(! preg_match($re, $data['email'])) {
            $poruka .= "E-mail nije ispravan!<br>";
        }      
        // ako jeste da li postoji vec registrovani korisnik sa tim e-mailom
        else if($korisnikModel->where('email', $data['email'])->first()) {
            $poruka .= "Već postoji registrovani korisnik sa tom e-mail adresom!<br>";
        }
        
        
        // provera da li lozinka ima izmedju 3 i 16 karaktera (bilo koji karakteri dozvoljeni)
        if(! preg_match('/^(.){3,16}$/', $data['password'])) {
            $poruka .= "Lozinka mora imati 3-16 karaktera!<br>";
        }        
        // ako jeste provera da li se lozinka i potvrda lozinke slazu
        else if ($data['password'] !== $data['passwordRep']) {
            $poruka .= "Lozinka se ne slaže sa potvrdom lozinke!<br>";
        }       
        
        // ako postoji bilo koja greska ispisi je
        if($poruka!="") {
            return $this->register($poruka);
        }
        
        // ako ne postoji napravi novog korisnika
        $idKorisnika = $korisnikModel->dodajNovogKorisnika($data);        
        $data2['idRegistrovanog'] = $idKorisnika;
        $data2['obrisanNalog'] = 0;
        $registrovaniModel=new RegistrovaniModel();
        $registrovaniModel->insert($data2);
        
        $korisnik=$korisnikModel->dohvatiKorisnikaPoImenu($data['username']);
        $korisnik->isAdmin=false;
        $this->session->set('korisnik', $korisnik);
        
        return redirect()->to(site_url('Korisnik'));
    }
}
