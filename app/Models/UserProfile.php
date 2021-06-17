<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class UserProfile extends Model
{
    use HasFactory;
    protected $table = "user_profiles";

    public function user(){
        return $this->belongsTo(User::class);
    }

    protected $fillable = [
        "phone_number",
        "permanent_address",
        "state_of_origin",
        "profile_image",
        "user_id"
    ];
}
