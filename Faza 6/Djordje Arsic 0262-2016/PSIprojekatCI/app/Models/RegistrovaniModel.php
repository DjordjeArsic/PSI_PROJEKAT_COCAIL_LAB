<?php
namespace App\Models;
use CodeIgniter\Model;
class RegistrovaniModel extends Model
{
    protected $table      = 'registrovani';
    protected $primaryKey = 'idRegistrovanog';

    protected $returnType     = 'object';

    protected $allowedFields = ['obrisanNalog'];
}