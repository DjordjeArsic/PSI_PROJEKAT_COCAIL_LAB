<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Controllers;
use App\Models\KoktelModel;
use App\Models\RazlogModel;
use App\Models\PrijavaModel;
use App\Models\RazloziPrijaveModel;
use App\Models\RegistrovaniModel;
use App\Models\SastojakModel;
use App\Models\SadrziObaveznoModel;
use App\Models\SadrziNeobaveznoModel;
/**
 * Description of Usercontroller
 *
 * @author Djole
 */
class Korisnik extends BaseController{
    
    protected function prikaz($header, $page, $data){
        echo view($header);
        echo view($page,$data);
        echo view("sablon/footer");
    }
    
    public function index(){
	echo view('sablon/header_user');
        echo view('sablon/footer');
    }
    
    public function mojiKokteli(){
        $koktelModel = new KoktelModel();
        //$korisnik = $this->session->get('korisnik');
        //$kokteli=$koktelModel->receptiKorisnika($session->get($korisnik->idKorisnika));
        $kokteli=$koktelModel->receptiKorisnika(2);
        $this->prikaz('sablon/header_user','stranice/mojirecepti', ['kokteli'=>$kokteli]);
    }
    
    public function brisanjeMogRecepta(){
        $idKoktela = $this->request->getPost('idKoktela');
        $koktelModel = new KoktelModel();
        $koktelModel->set("obrisan",1)->where('idKoktela',$idKoktela)->update();
        $this->mojiKokteli();
    }
    
    public function test(){
        $registrovaniModel = new RegistrovaniModel();
        $registrovani = $registrovaniModel->find(3);
        $koktelModel = new KoktelModel();
        $koktel = $koktelModel->find(2);
        $razlogModel = new RazlogModel();
        $razlozi = $razlogModel->findall();
        $this->prikaz('sablon/header_user', 'stranice/tudjirecept', ['koktel' => $koktel,'razlozi' => $razlozi, 'registrovani'=>$registrovani]);
    }
    
    public function reportovanjeTudjegRecepta(){
            $idKoktela = $this->request->getPost('idKoktela');
            $idRegistrovanog = $this->request->getPost('idRegistrovanog');
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
                echo view('sablon/header_user');
                echo view('sablon/footer');      
    }
    
    public function mojKoktel($idKoktela){
        $koktelModel = new KoktelModel();
        $sadrziObaveznoModel = new SadrziObaveznoModel();
        $sadrziNeobaveznoModel = new SadrziNeobaveznoModel();
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
        $this->prikaz('sablon/header_user', 'stranice/mojrecept', ['koktel' => $koktel, 'obaveznisastojci'=> $obaveznisastojci, 'obaveznisastojci_kolicina'=>$obaveznisastojci_kolicna, 'neobaveznisastojci'=> $neobaveznisastojci, 'neobaveznisastojci_kolicina'=>$neobaveznisastojci_kolicna]);
    }
}
