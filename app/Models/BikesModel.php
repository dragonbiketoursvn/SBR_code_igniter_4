<?php

namespace App\Models;

class BikesModel extends \CodeIgniter\Model
{
  protected $table = 'bikes';
  protected $primaryKey = 'plate_number';

  protected $allowedFields = [
    'plate_number', 'purchase_date', 'brand', 'model', 'year', 'purchase_price', 'extra_key',
    'giay_ban_xe', 'giay_uy_quyen', 'Nga_dung_ten', 'ownership_details', 'sale_date', 'sale_price',
    'notes', 'photo_path', 'Kim_Anh_dung_ten', 'dragon_bikes', 'insurance_expires', 'reg_front', 'reg_back',
    'pic_front', 'pic_side', 'pic_rear', 'pic_trunk', 'purchased_from'
  ];

  protected $returnType = 'App\Entities\Bike';

  protected $useTimestamps = false;

  protected $validationRules = ['year' => 'numeric',];
  protected $validationMessages = ['year' => ['numeric' => 'Please enter a valid year']];

  protected $beforeUpdate = ['trimWhiteSpace'];
  protected $beforeInsert = ['trimWhiteSpace'];

  protected function trimWhiteSpace($data)
  {
    array_walk($data['data'], function (&$item) {

      $item = trim($item);
    });

    return $data;
  }

  public function getCurrentBikes()
  {
    return $this->where('sale_date', '0000-00-00')
      ->orWhere('sale_date', null)
      ->findAll();
  }

  public function getCurrentModels()
  {
    return $this->select('model')
      ->distinct()
      ->where('sale_date', '0000-00-00')
      ->orWhere('sale_date', null)
      ->orderBy('model')
      ->get()
      ->getResult();
  }

  public function getAllBikes()
  {
    return $this->findAll();
  }

  public function getBikeByPlateNumber($plateNumber)
  {
    return $this->where('plate_number', $plateNumber)
      ->first();
  }

  public function getDragonBikes()
  {
    return $this->where('dragon_bikes', 1)
      ->findAll();
  }
}
