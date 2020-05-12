<?php

class AdminModel extends Model
{
    protected $table      = 'admin';
    protected $primaryKey = 'idAdmina';

    protected $returnType     = 'object';
    protected $useSoftDeletes = true;

}

