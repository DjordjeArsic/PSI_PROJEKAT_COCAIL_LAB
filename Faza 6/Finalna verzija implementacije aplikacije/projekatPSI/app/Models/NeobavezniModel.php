<?php namespace App\Models;


use CodeIgniter\Model;

// Neobavezni model - rad sa neobaveznim sastojcima koktela u bp
// Autor: Jelena Dragojevic - 2017/0440, Djordje Arsic - 2016/0262
// @verzija 1.0
class NeobavezniModel extends Model {
        // polja modela koja se odnose na tabelu i povratnu vrednost
        protected $table      = 'sadrzineobavezno';
        protected $returnType = 'object';
        
        // dozvoljena polja za update i insert
        protected $allowedFields = ['idKoktela', 'idSastojka', 'kolicina'];
}
