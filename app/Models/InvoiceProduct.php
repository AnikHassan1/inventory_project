<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceProduct extends Model
{
   protected $table='invoice_products';
   protected $fillable =["Invoice_id","user_id", "product_id","qty","sales_price"];
}
