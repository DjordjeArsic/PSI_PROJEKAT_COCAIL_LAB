<?php namespace App\Models;


use CodeIgniter\Model;

class ObavezniModel extends Model
{
        protected $table      = 'sadrziobavezno';
        //protected $primaryKey = 'idKoktela';
        protected $returnType = 'object';
    
        protected $allowedFields = ['idKoktela', 'idSastojka', 'kolicina'];
}
