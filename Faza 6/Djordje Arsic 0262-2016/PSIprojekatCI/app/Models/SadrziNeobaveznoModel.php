<?php
namespace App\Models;
use CodeIgniter\Model;


class SadrziNeobaveznoModel extends Model
{
    protected $table      = 'sadrzineobavezno';

    protected $returnType     = 'object';
  

    protected $allowedFields = ['idKoktela', 'idSastojka', 'kolicina'];
}