<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    use HasFactory;
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function chief()
    {
        return $this->hasOne(User::class);
    }
    protected $fillable =['RequestDate','Status','StartDate','EndDate','user_id',];

    protected static function booted() {
        static::updated(function ($leave) {
            if ($leave->isDirty('Status') && $leave->Status != 'Accepted') {
                $event = Event::where('title', $leave->user->name)
                    ->where('start', $leave->StartDate)
                    ->where('end', $leave->EndDate)
                    ->first();
                if($event) {
                    $event->delete();
                }
            }
        });
    }

}
