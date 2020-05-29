<?php namespace App\Models;

use CodeIgniter\Model;

class RegistrovaniModel extends Model {
        protected $table      = 'registrovani';
        protected $primaryKey = 'idRegistrovanog';
        protected $returnType = 'object';
    
        protected $allowedFields = [ 'idRegistrovanog', 'obrisanNalog'];
        
        //dodati f-ju koja menja obrisanNalog na 1
        
        public function isObrisan($idRegistrovanog) {
            return ($this->find($idRegistrovanog)->obrisanNalog==1)?true:false;
        }
}
