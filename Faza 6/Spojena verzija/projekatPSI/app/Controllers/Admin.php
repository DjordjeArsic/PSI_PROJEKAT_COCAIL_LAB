<?php namespace App\Controllers;

class Admin extends Korisnik {   
    public function index(){
        return redirect()->to(site_url('Pretraga'));
    } 
}
