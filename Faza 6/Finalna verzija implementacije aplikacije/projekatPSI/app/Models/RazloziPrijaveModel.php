<?php
namespace App\Models;
use CodeIgniter\Model;

// Razlog model - rad sa razlozima prijave koktela u bp
// Autor: Djordje Arsic - 2016/0262, Stefan Radenkovic - 2017/0573
// @verzija 1.0
class RazloziPrijaveModel extends Model {
    // polja modela koja se odnose na tabelu i povratnu vrednost
    protected $table      = 'razloziprijave';
    protected $returnType     = 'object';
    protected $allowedFields = ['idKoktela', 'idRegistrovanog', 'idRazloga', 'duplikat'];
}

