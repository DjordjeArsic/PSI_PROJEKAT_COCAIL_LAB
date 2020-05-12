<?php
namespace App\Models;
use CodeIgniter\Model;

class SadrziObaveznoModel extends Model
{
    protected $table      = 'sadrziobavezno';

    protected $returnType     = 'object';


    protected $allowedFields = ['idKoktela', 'idSastojka', 'kolicina'];
}

