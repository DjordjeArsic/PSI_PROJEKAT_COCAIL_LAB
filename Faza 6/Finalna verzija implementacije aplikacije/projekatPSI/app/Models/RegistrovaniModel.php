<?php namespace App\Models;

use CodeIgniter\Model;

// Razlog model - rad sa registrovanim korisnicima u bp
// Autor: Jelena Dragojevic 2017/0440
// @verzija 1.0
class RegistrovaniModel extends Model {
        // polja modela koja se odnose na tabelu, primarni kljuc i povratnu vrednost
        protected $table      = 'registrovani';
        protected $primaryKey = 'idRegistrovanog';
        protected $returnType = 'object';
    
        // dozvoljena polja za update i insert
        protected $allowedFields = [ 'idRegistrovanog', 'obrisanNalog'];
        
        // metoda koja vraca informaciju da li je obrisan zadati korinsik 
        public function isObrisan($idRegistrovanog) {
            return ($this->find($idRegistrovanog)->obrisanNalog==1)?true:false;
        }
}
