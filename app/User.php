<?php

namespace App;

use Twilio\Rest\Client;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'phone', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'phone_verified_at' => 'datetime',
    ];

  
    public function hasVerifiedPhone()
    {
        return ! is_null($this->phone_verified_at);
    }

    public function markPhoneAsVerified()
    {
        return $this->forceFill([
            'phone_verified_at' => $this->freshTimestamp(),
        ])->save();
    }

    public function callToVerify()
    {
        $code = random_int(100000, 999999);
        
        $this->forceFill([
            'verification_code' => $code
        ])->save();

        $client = new Client(env('TWILIO_SID'), env('TWILIO_AUTH_TOKEN'));

        $client->calls->create(
            $this->phone,
            "+15306658566",
            ["url" => "http://16c8f00a.ngrok.io/build-twiml/{$code}"]
        );
    }
}
