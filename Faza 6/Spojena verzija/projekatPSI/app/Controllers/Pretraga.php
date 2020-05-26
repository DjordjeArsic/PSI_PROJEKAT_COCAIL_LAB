<?php namespace App\Controllers;

use App\Models\SastojakModel;
use App\Models\ObavezniModel;
use App\Models\NeobavezniModel;
use App\Models\KoktelModel;
use App\Models\RazlogModel;

// Pretraga kontroler - klasa za upravljanje akcijama pretrage koktela
// Autor: Jelena Dragojevic - 2017/0440, Marko Stankovic - 2017/0331
// @verzija 1.0
class Pretraga extends BaseController {
    
    // rezultat: prikaz pocetne stranice pretrage
    public function index($poruka=null) {
        $recepti = $this->session->get('kokteliZaIspis');
        $sastojciIzSesije = $this->session->get('sastojci');
        $sastojakModel = new SastojakModel();
        $sastojci = $sastojakModel->dohvatiSastojke();
        return $this->prikaz("pretraga", ['sastojci'=>$sastojci, 'recepti'=>$recepti, 'poruka'=>$poruka, 'sastojciIzSesije' => $sastojciIzSesije]);
    }
    
    // na osnovu idKoktela vraca se objekat koktela sa svim sastojcima
    private function dohvKoktelsaSastojcima($idKoktela) {
        $koktelModel = new KoktelModel();
        $sadrziObaveznoModel = new ObavezniModel();
        $sadrziNeobaveznoModel = new NeobavezniModel();
        $sastojakModel= new SastojakModel();
        
        $sadrziObavezno = $sadrziObaveznoModel->where('idKoktela',$idKoktela)->findall();
        $sadrziNeobavezno = $sadrziNeobaveznoModel->where('idKoktela',$idKoktela)->findall();
        $obavezniSastojci = []; // sadrzi naziv sastojka i kolicinu
        $neobavezniSastojci = []; // sadrzi naziv sastojka i kolicinu
                 
        foreach($sadrziObavezno as $so){
            $sastojak = $sastojakModel->find($so->idSastojka);
            $obavezniSastojci[]= (object)['naziv' => $sastojak->naziv,
                                          'kolicina' => $so->kolicina];
        }
        foreach($sadrziNeobavezno as $sno){
            $sastojak = $sastojakModel->find($sno->idSastojka);
            $neobavezniSastojci[]= (object)['naziv' => $sastojak->naziv,
                                        'kolicina' => $sno->kolicina];
        }
        $koktel = $koktelModel->find($idKoktela);
        
        return (object)['koktel'=> $koktel,
                        'obavezniSastojci'=> $obavezniSastojci,
                        'neobavezniSastojci'=> $neobavezniSastojci];
    }
    
    // obrada zahteva za pretragu za unete sastojke
    // rezultat: pocetna stranica sa rezultatima pretrage
    public function pretragaSubmit() { 
                
        $sastojci = $this->request->getPost('sastojci');
                   
        if($sastojci == NULL) {
            $poruka = 'Niste uneli nijedan sastojak!';
            return $this->index($poruka);
        }
             
        
        $obavezniModel = new ObavezniModel();
        $koktelModel = new KoktelModel();
        $obavezni = $obavezniModel->orderBy('idKoktela')->findAll();
        
               
        $kokteliZaIspis = [];
        $sastojciKoktela = [];
        
        // ova petlja pravi matricu gde vrste odgovaraju idKoktela, a kolone idSastojka
        foreach($obavezni as $value) {
            if ($koktelModel->find($value->idKoktela)->obrisan==1) continue;
            
            if (!array_key_exists($value->idKoktela, $sastojciKoktela)) {
                $sastojciKoktela[$value->idKoktela] = [];  
            }
            array_push($sastojciKoktela[$value->idKoktela], $value->idSastojka);
        }
        
        
        // ova pretlja za svaki koktel provera da li su uneti svi obavezni sastojci
        foreach($sastojciKoktela as $koktelId => $nizSastojaka) {
            if (!array_diff($nizSastojaka, $sastojci)) {
                array_push($kokteliZaIspis, $this->dohvKoktelsaSastojcima($koktelId));
            }
        }
        

        $this->session->set('kokteliZaIspis', $kokteliZaIspis);
        
        if(count($kokteliZaIspis)==0) {
            $poruka="Nema rezultata pretrage!";
            return $this->index($poruka);
        }
        
        return redirect()->to(site_url('Pretraga/index'));
    }
    
    // rezultat: prikaz stranice konkretnog koktela
    public function koktel($idKoktela) {
        
        $koktelModel = new KoktelModel();
        $sadrziObaveznoModel = new ObavezniModel();
        $sadrziNeobaveznoModel = new NeobavezniModel();
        $sastojakModel= new SastojakModel();
        
        $sadrziObavezno = $sadrziObaveznoModel->where('idKoktela',$idKoktela)->findall();
        $sadrziNeobavezno = $sadrziNeobaveznoModel->where('idKoktela',$idKoktela)->findall();
        $obavezniSastojci = []; // sadrzi naziv sastojka i kolicinu
        $neobavezniSastojci = []; // sadrzi naziv sastojka i kolicinu
                 
        foreach($sadrziObavezno as $so){
            $sastojak = $sastojakModel->find($so->idSastojka);
            $obavezniSastojci[]= (object)['naziv' => $sastojak->naziv,
                                          'kolicina' => $so->kolicina];
        }
        foreach($sadrziNeobavezno as $sno){
            $sastojak = $sastojakModel->find($sno->idSastojka);
            $neobavezniSastojci[]= (object)['naziv' => $sastojak->naziv,
                                        'kolicina' => $sno->kolicina];
        }
        $koktel = $koktelModel->find($idKoktela);
        $razlogModel = new RazlogModel();
        $razlozi = $razlogModel->findAll();
        
        return $this->prikaz("koktel", ['koktelInfo' =>
                                        (object)['koktel'=> $koktel,
                                                 'obavezniSastojci'=> $obavezniSastojci,
                                                 'neobavezniSastojci'=> $neobavezniSastojci
                                                ],
                                        'korisnik' => $this->session->get('korisnik'),
                                        'razlozi' => $razlozi]);
    }
}
