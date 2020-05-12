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
class Usercontroller extends BaseController{
    
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
        $kokteli=$koktelModel->receptiKorisnika('2');
        $this->prikaz('sablon/header_user','stranice/mojirecepti', ['kokteli'=>$kokteli]);
    }
    
    public function brisanjeMogRecepta($idKoktela){
        $koktelModel = new KoktelModel();
        $koktelModel->set("obrisan",1)->where('idKoktela',$idKoktela)->update();
        $this->mojiKokteli();
    }
    
    public function test(){
        $registrovaniModel = new RegistrovaniModel();
        $registrovani = $registrovaniModel->find(3);
        $koktelModel = new KoktelModel();
        $koktel = $koktelModel->find(3);
        $razlogModel = new RazlogModel();
        $razlozi = $razlogModel->findall();
        $this->prikaz('sablon/header_user', 'stranice/tudjirecept', ['koktel' => $koktel,'razlozi' => $razlozi, 'registrovani'=>$registrovani]);
    }
    
    public function reportovanjeTudjegRecepta($idKoktela, $idKorisnika){
        if(!empty('r')){
            $prijavaModel = new PrijavaModel();
            $razloziprijaveModel = new RazloziPrijaveModel();
            $prijavaModel->insert(['idKoktela' => $idKoktela, 'idRegistrovanog' => $idKorisnika, 'datum' => date('Y-m-d'), 'obrisanaprijava'=>0]);
            foreach($r as $razlog){
                $razozprijaveModel->insert(['idRegistrovanog' => $idKorisnika,'idKoktela' => $idKoktela, 'idRazloga'=> $razlog]);
            }
            echo view('sablon/header_user');
            echo view('sablon/footer');
        }
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
