<?php namespace App\Controllers;

class Admin extends Korisnik
{
    
    public function index(){
            $korisnik = $this->session->get('korisnik');
            return $this->prikaz("loggedIn", ['korisnickoIme'=>$korisnik->username]);
    }
   
}
