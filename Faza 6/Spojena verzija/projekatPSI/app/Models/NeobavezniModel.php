<?php namespace App\Models;


use CodeIgniter\Model;

class NeobavezniModel extends Model {
        protected $table      = 'sadrzineobavezno';
        //protected $primaryKey = 'idKoktela';
        protected $returnType = 'object';
    
        protected $allowedFields = ['idKoktela', 'idSastojka', 'kolicina'];
}
