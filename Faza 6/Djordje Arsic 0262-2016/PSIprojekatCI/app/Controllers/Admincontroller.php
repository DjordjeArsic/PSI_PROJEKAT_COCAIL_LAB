<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Controllers;


class Adminrcontroller extends Usercontroller{
    
    public function index(){
	return view('welcome_message');
    }
    
    public function pretragaKoktela(){
        
    }
    
}