<?php namespace App\Controllers;

use App\Models\SastojakModel;
use App\Models\ObavezniModel;
use App\Models\KoktelModel;

class Pretraga extends BaseController {
    public function index($poruka=null, $recepti=null) {
        $sastojakModel = new SastojakModel();
        $sastojci = $sastojakModel->dohvatiSastojke();
        return $this->prikaz("pretragaForma", ['sastojci'=>$sastojci, 'recepti'=>$recepti, 'poruka'=>$poruka]);
    }
    
    public function pretragaSubmit() {  
        $sastojci = $this->request->getPost('sastojci');
        if($sastojci==null){
            $poruka='Niste uneli nijedan sastojak!';
            return $this->index($poruka);
        }
        
        $obavezniModel = new ObavezniModel();
        $obavezni = $obavezniModel->orderBy('idKoktela')->findAll();
        
        
        $kokteliZaIspis=[];
        $formaNiz = [1,2];
        $sastojciKoktela = [];
        // ova petlja pravi matricu gde vrste odgovaraju idKoktela, a kolone idSastojka
        foreach($obavezni as $value) {
            if (!array_key_exists($value->idKoktela, $sastojciKoktela)) {
                $sastojciKoktela[$value->idKoktela] = [];  
            }
            array_push($sastojciKoktela[$value->idKoktela], $value->idSastojka);
        }
        // ova pretlja za svaki koktel provera da li su uneti svi obavezni sastojci
        $koktelModel = new KoktelModel();
        foreach($sastojciKoktela as $koktelId => $nizSastojaka) {
            if (!array_diff($nizSastojaka, $sastojci)) {
                array_push($kokteliZaIspis, $koktelModel->find($koktelId));
            }
        }
        
        if(count($kokteliZaIspis)==0) {
            $poruka="Nema rezultata pretrage!";
            return $this->index($poruka);
        }
        
        return $this->index(null, $kokteliZaIspis);
    }
    
    public function koktel($idKoktela) {
        //todo: dohavti info o koktelu na osnovu id, i prosledi stranici za prikaz koktela
        //todo: uloge imaju razlicite dugmice
        echo $idKoktela;
    }
}
