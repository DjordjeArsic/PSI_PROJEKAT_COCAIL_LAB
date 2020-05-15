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
        $kokteli=$koktelModel->receptiKorisnika('2');
        $this->prikaz('sablon/header_user','stranice/mojirecepti', ['kokteli'=>$kokteli]);
    }
    
    public function brisanjeMogRecepta($idKoktela){
        $koktelModel = new KoktelModel();
        $koktelModel->set("obrisan",1)->where('idKoktela',$idKoktela)->update();
        $this->mojiKokteli();
    }
    
    public function test(){
        $poruka='';
        $registrovaniModel = new RegistrovaniModel();
        $registrovani = $registrovaniModel->find(2);
        $koktelModel = new KoktelModel();
        $koktel = $koktelModel->find(2);
        $razlogModel = new RazlogModel();
        $razlozi = $razlogModel->findall();
        $this->prikaz('sablon/header_user', 'stranice/tudjirecept', ['koktel' => $koktel,'razlozi' => $razlozi, 'registrovani'=>$registrovani, 'poruka'=>$poruka]);
    }
    
    public function reportovanjeTudjegRecepta($idKoktela, $idRegistrovanog){
            $razlogModel = new RazlogModel();
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
            $poruka_prijave='';
            if(empty($razloziprijave)){
                $poruka_prijave= $poruka_prijave.'Morate uneti razlog prijave!<br/>';
                $greska=1;
            }
            if(($duplikat==NULL)&&($razlog_duplikat ==1)){
                $poruka_prijave= $poruka_prijave.'Morate uneti originalni recept ako tvrite da je ovaj recept duplikat!<br/>';
                $greska=1; 
            }
            if($greska=1){
                $registrovaniModel = new RegistrovaniModel();
                $koktelModel = new KoktelModel();
                $registrovani = $registrovaniModel->find($idRegistrovanog);
                $koktel = $koktelModel->find($idKoktela);
                $this->prikaz('sablon/header_user', 'stranice/tudjirecept', ['koktel' => $koktel,'razlozi' => $razlozi, 'registrovani'=>$registrovani, 'poruka'=>$poruka_prijave]);
            }
            else{
                $prijavaModel = new PrijavaModel();
                $razloziPrijaveModel = new RazloziPrijaveModel();
                $prijavaModel->insert(['idKoktela' => $idKoktela, 'idRegistrovanog' => $idRegistrovanog, 'datum' => date('Y-m-d'), 'obrisanaPrijava'=>0]);
                foreach($razloziprijave as $razlogprijave){
                    if($razlogprijave==3){
                        $razloziPrijaveModel->insert(['idKoktela' => $idKoktela, 'idRegistrovanog' => $idRegistrovanog, 'idRazloga' => $razlogprijave, 'duplikat'=> $duplikat]);
                    }
                    else{
                        $razloziPrijaveModel->insert(['idKoktela' => $idKoktela, 'idRegistrovanog' => $idRegistrovanog, 'idRazloga' => $razlogprijave]);
                    }
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
