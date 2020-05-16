<?php
namespace App\Models;
use CodeIgniter\Model;

class KoktelModel extends Model
{
    protected $table      = 'koktel';
    protected $primaryKey = 'idKoktela';

    protected $returnType     = 'object';

    protected $allowedFields = ['idKorisnika', 'naziv', 'opis', 'slika', 'video', 'obrisan', 'datum'];
    
    public function receptiKorisnika($idKorisnika) {
            return $this->where('koktel.idKorisnika', $idKorisnika)->where('obrisan',0)->findall();
    }
    
    
}
