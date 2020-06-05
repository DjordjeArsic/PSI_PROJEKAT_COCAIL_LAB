<?php namespace App\Models;


use CodeIgniter\Model;

// Obavezni model - rad sa obaveznim sastojcima koktela u bp
// Autor: Jelena Dragojevic - 2017/0440, Marko Stankovic - 2017/0331
// @verzija 1.0
class ObavezniModel extends Model {
         // polja modela koja se odnose na tabelu i povratnu vrednost
        protected $table      = 'sadrziobavezno';
        protected $returnType = 'object';
        
        // dozvoljena polja za update i insert
        protected $allowedFields = ['idKoktela', 'idSastojka', 'kolicina'];
}
