<?php
namespace App\Models;
use CodeIgniter\Model;

// Prijava model - rad sa prijavama u bp
// Autor: Djordje Arsic - 2016/0262, Stefan Radenkovic - 2017/0573
// @verzija 1.0
class PrijavaModel extends Model {
    // polja modela koja se odnose na tabelu i povratnu vrednost
    protected $table      = 'prijava';
    protected $returnType     = 'object';
    protected $allowedFields = ['idKoktela', 'idRegistrovanog', 'datum', 'obrisanaPrijava'];
}

