<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Computer extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $dates = [
        'discount_datetime_start',
        'discount_datetime_end',
        'created_at',
        'updated_at',
    ];

    protected $hidden = ['pivot'];


    public function category()
    {
        return $this->belongsTo(Category::class);
    }


    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }


    public function values()
    {
        return $this->belongsToMany(Value::class, 'computer_values')
            ->orderBy('computer_values.sort_order');
    }


    public function isDiscount()
    {
        if ($this->discount_percent > 0 and $this->discount_datetime_start <= Carbon::now()->toDateTimeString() and $this->discount_datetime_end >= Carbon::now()->toDateTimeString()) {
            return true;
        } else {
            return false;
        }
    }


    public function isNew()
    {
        if ($this->created_at >= Carbon::today()->subMonth()->toDateTimeString()) {
            return true;
        } else {
            return false;
        }
    }


    public function price()
    {
        if ($this->isDiscount()) {
            return round($this->price * (1 - $this->discount_percent / 100), 1);
        } else {
            return round($this->price, 1);
        }
    }


    public function image()
    {
        if ($this->image) {
            return Storage::url('public/computers/' . $this->image);
        } else {
            return asset('img/temp/computer-sm.jpg');
        }
    }
}
