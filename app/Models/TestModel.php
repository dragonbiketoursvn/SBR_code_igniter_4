<?php

namespace App\Models;

use CodeIgniter\Model;

class TestModel extends Model
{
  protected $table = 'testGithubIssue';
  protected $useAutoIncrement = false;
  protected $allowedFields = ['id', 'name',];
}
