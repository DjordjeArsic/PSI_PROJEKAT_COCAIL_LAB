<?php
namespace App\Models;
use CodeIgniter\Model;

// Razlog model - rad sa mogucim razlozima prijave u bp
// Autor: Djordje Arsic - 2016/0262, Stefan Radenkovic - 2017/0573
// @verzija 1.0
class RazlogModel extends Model {
    // polja modela koja se odnose na tabelu, primarni kljuc i povratnu vrednost
    protected $table      = 'razlog';
    protected $primaryKey = 'idRazloga';
    protected $returnType     = 'object';
}