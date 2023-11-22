<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * @method static first()
 */
class Setting extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'ip_address',
        'port',
        'ldap_host',
        'ldap_username',
        'ldap_password',
        'ldap_port',
        'ldap_base_dn',
        'ldap_timeout',
        'login_text',
        'kiosk_password',
        'checked_invited',
        'type',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('logo')->singleFile();
        $this->addMediaCollection('logo_dark')->singleFile();
    }
}
