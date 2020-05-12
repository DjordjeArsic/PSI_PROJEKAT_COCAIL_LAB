<?php

class KorisnikModel extends Model
{
    protected $table      = 'korisnik';
    protected $primaryKey = 'idKorisnika';
    protected $returnType     = 'object';
    protected $allowedFields = ['username', 'password', 'email'];
}