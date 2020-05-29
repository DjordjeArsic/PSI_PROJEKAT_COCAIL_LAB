<?php namespace App\Models;


use CodeIgniter\Model;

class SastojakModel extends Model {
        protected $table      = 'sastojak';
        protected $primaryKey = 'idSastojka';
        protected $returnType = 'object';
    
        protected $allowedFields = [ 'idSastojka', 'naziv'];
        
        public function dohvatiImenaSastojaka() {
            return $this->findColumn('naziv');
        }
        
        public function dohvatiSveId() {
            return $this->findColumn('idSastojka');
        }
        
        public function dohvatiIdPoNazivu($naziv) {
            return $this->where('naziv', $naziv)->first()->idSastojka;
        }
        
        public function dohvatiSastojke() {
            return $this->findAll();
        }
}
