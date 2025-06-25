<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutSetting extends Model
{
  use HasFactory;

  protected $fillable = [
    'biography',
    'skills',
    'resume_path',
  ];

  protected $casts = [
    'skills' => 'array',
  ];

  /**
   * Get the instance of about settings or create one if it doesn't exist
   */
  public static function getInstance()
  {
    return static::firstOrCreate();
  }
}
