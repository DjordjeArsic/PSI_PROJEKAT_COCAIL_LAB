<?php namespace App\Models;


use CodeIgniter\Model;

// Razlog model - rad sa razlozima prijave u bp
// Autor: Jelena Dragojevic - 2017/0440, Marko Stankovic - 2017/0331
// @verzija 1.0
class SastojakModel extends Model {
        // polja modela koja se odnose na tabelu, primarni kljuc i povratnu vrednost
        protected $table      = 'sastojak';
        protected $primaryKey = 'idSastojka';
        protected $returnType = 'object';
        
        // dozvoljena polja za update i insert
        protected $allowedFields = [ 'idSastojka', 'naziv'];
        
        // dohvataju se imena svih sastojaka
        public function dohvatiImenaSastojaka() {
            return $this->findColumn('naziv');
        }
        
        // dohvataju se id svih sastojaka
        public function dohvatiSveId() {
            return $this->findColumn('idSastojka');
        }
        
        // dohvata se id koktela na osnovu zadatog naziva koktela
        public function dohvatiIdPoNazivu($naziv) {
            return $this->where('naziv', $naziv)->first()->idSastojka;
        }
        
        // dohvataju se svi sastojci iz bp 
        public function dohvatiSastojke() {
            return $this->findAll();
        }
}
