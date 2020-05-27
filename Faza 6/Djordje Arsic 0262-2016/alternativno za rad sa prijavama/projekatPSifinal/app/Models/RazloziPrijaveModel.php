<?php
namespace App\Models;
use CodeIgniter\Model;

class RazloziPrijaveModel extends Model {
    protected $table      = 'razloziprijave';

    protected $returnType     = 'object';
    protected $allowedFields = ['idKoktela', 'idRegistrovanog', 'idRazloga', 'duplikat', 'datum'];
}

