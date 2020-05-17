<?php
namespace App\Models;
use CodeIgniter\Model;

class PrijavaModel extends Model {
    protected $table      = 'prijava';

    protected $returnType     = 'object';

    protected $allowedFields = ['idKoktela', 'idRegistrovanog', 'datum', 'obrisanaPrijava'];
}

