<?php namespace App\Models;

use CodeIgniter\Model;

// Admin model - klasa rad sa adminom u bp
// Autor: Jelena Dragojevic - 2017/0440, Stefan Radenkovic -2017/0573
// @verzija 1.0
class AdminModel extends Model {
        // polja modela koja se odnose na tabelu, primarni kljuc i povratnu vrednost
        protected $table      = 'admin';
        protected $primaryKey = 'idAdmina';
        protected $returnType = 'object';
        
        // provera da li je korisnik admin
        // rezultat: true/false
        public function proveraDaLiJeAdmin($id) {
            return ($this->find($id)==null)?false:true;
        }
}
