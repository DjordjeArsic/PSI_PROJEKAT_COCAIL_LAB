<?php namespace App\Models;


use CodeIgniter\Model;

// Koktel model - rad sa koktelima u bp
// Autor: Djordje Arsic - 2016/0262, Marko Stankovic 2017/0331
// @verzija 1.0
class KoktelModel extends Model {
        // polja modela koja se odnose na tabelu, primarni kljuc i povratnu vrednost
        protected $table      = 'koktel';
        protected $primaryKey = 'idKoktela';
        protected $returnType = 'object';
    
        // dozvoljena polja za update i insert
        protected $allowedFields = ['idKoktela', 'idKorisnika', 'naziv', 'opis', 'slika', 'video', 'obrisan', 'datum'];
        
        // ubaci novi koktel u bp
        // rezultat: id novonastalog koktela
        public function napraviNoviKoktel($data) {
            $this->insert($data);
            return $this->getInsertID();
        }
        
        // za zadatog korsinika dohvati sve recepte datog korisnika
        public function receptiKorisnika($idKorisnika) {
            return $this->where('koktel.idKorisnika', $idKorisnika)->where('obrisan',0)->findall();
        }
}
