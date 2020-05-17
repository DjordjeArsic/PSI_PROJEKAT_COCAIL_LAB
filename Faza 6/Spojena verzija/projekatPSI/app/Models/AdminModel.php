<?php namespace App\Models;

use CodeIgniter\Model;

class AdminModel extends Model {
        protected $table      = 'admin';
        protected $primaryKey = 'idAdmina';
        protected $returnType = 'object';
        
        public function proveraDaLiJeAdmin($id) {
            return ($this->find($id)==null)?false:true;
        }
}
