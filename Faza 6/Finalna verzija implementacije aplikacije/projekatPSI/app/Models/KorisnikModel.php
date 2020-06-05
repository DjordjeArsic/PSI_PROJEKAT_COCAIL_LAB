<?php namespace App\Models;

use CodeIgniter\Model;

// Korisnik model - klasa za rad sa korsinikom u bp
// Autor: Jelena Dragojevic - 2017/0440, Marko Stankovic - 2017/0331
// @verzija 1.0
class KorisnikModel extends Model {
    // polja modela koja se odnose na tabelu, primarni kljuc i povratnu vrednost
    protected $table      = 'korisnik';
    protected $primaryKey = 'idKorisnika';
    protected $returnType = 'object';

    // dozvoljena polja za update i insert
    protected $allowedFields = [ 'idKorisnika', 'username', 'password', 'email'];

    // dohvati korisnika za dati username
    public function dohvatiKorisnikaPoImenu($korisnickoIme) {
        return $this->where('username', $korisnickoIme)->first();
    }
    
    // ubacivanje novog korsinika u bazu
    // rezulta: id novokreiranog korisnika
    public function dodajNovogKorisnika($data) {
        $this->insert($data);
        $korisnik = $this->where('username', $data['username'])->first();
        return $korisnik->idKorisnika;
    }
}
