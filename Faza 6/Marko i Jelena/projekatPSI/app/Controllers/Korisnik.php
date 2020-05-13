<?php namespace App\Controllers;

class Korisnik extends BaseController
{
    
    public function index(){
            $korisnik = $this->session->get('korisnik');
            return $this->prikaz("loggedIn", ['korisnickoIme'=>$korisnik->username]);
    }

}