<?php namespace App\Models;

use CodeIgniter\Model;

class KorisnikModel extends Model {
    protected $table      = 'korisnik';
    protected $primaryKey = 'idKorisnika';
    protected $returnType = 'object';

    protected $allowedFields = [ 'idKorisnika', 'username', 'password', 'email'];

    public function dohvatiKorisnikaPoImenu($korisnickoIme) {
        return $this->where('username', $korisnickoIme)->first();
    }

    public function dodajNovogKorisnika($data) {
        $this->insert($data);
        $korisnik = $this->where('username', $data['username'])->first();
        return $korisnik->idKorisnika;
    }
}
