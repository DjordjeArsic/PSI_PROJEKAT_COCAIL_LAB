<?php
namespace App\Models;
use CodeIgniter\Model;

class RazlogModel extends Model
{
    protected $table      = 'razlog';
    protected $primaryKey = 'idRazloga';

    protected $returnType     = 'object';
}