<?php namespace App\Models;


use CodeIgniter\Model;

class SastojakModel extends Model
{
        protected $table      = 'sastojak';
        protected $primaryKey = 'idSastojka';
        protected $returnType = 'object';
    
        protected $allowedFields = [ 'idSastojka', 'naziv'];
        
        public function dohvatiSastojke() {
            return $this->findColumn('naziv');
        }
        
        public function dohvatiId($naziv) {
            return $this->where('naziv', $naziv)->first()->idSastojka;
        }
}
