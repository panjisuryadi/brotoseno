<?php


namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\File;
use Spatie\Permission\Traits\HasRoles;
use Modules\UserCabang\Models\UserCabang;
use Modules\Company\Models\Company;
use Modules\Cabang\Models\Cabang;
use Auth;

class User extends Authenticatable implements HasMedia
{
    use HasFactory, Notifiable, HasRoles, InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */



    public const USERCODE = 'U';

     public static function boot()
        {
            parent::boot();

            if(auth()->check()){
                if(auth()->user()->isUserCabang()){
                    $cabang = auth()->user()->namacabang()->id;
                    static::addGlobalScope('filter_by_branch', function (Builder $builder) use ($cabang) {
                        $builder->whereHas('namacabangs', function($query) use ($cabang){
                            $query->where('cabang_id',$cabang);
                        }); // Sesuaikan dengan nama kolom yang sesuai di tabel
                    });
                }
            }
        }

    protected $fillable = [
        'name',
        'email',
        'kode_user',
        'password',
        'is_active'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $with = ['media'];


    public function scopeAkses($query)
    {

     $users = Auth::user()->id;
     if ($users == 1) {
            return $query;
        }
        return $query->whereHas('namacabangs', function($query) {
               $query->where('cabang_id', Auth::user()->namacabang()->id);
            });
    }

    public function namacabangs(){
        return $this->belongsToMany(Cabang::class,'usercabangs','user_id','cabang_id')->using(UserCabang::class);
    }

     public function namacabang()
        {
            return $this->namacabangs()->latest()->first();
        }

      public function company() {
            return $this->hasMany(Company::class, 'id', 'user_id');
        }
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('avatars')
            ->useFallbackUrl('https://www.gravatar.com/avatar/' . md5($this->attributes['email']));
    }

     public static function generateCode()
        {
            $dateCode = self::USERCODE . '-';
            $lastOrder = self::select([\DB::raw('MAX(users.kode_user) AS last_code')])
                ->where('kode_user', 'like', $dateCode . '%')
                ->first();
            $lastOrderCode = !empty($lastOrder) ? $lastOrder['last_code'] : null;
            $orderCode = $dateCode . '00001';
            if ($lastOrderCode) {
                $lastOrderNumber = str_replace($dateCode, '', $lastOrderCode);
                $nextOrderNumber = sprintf('%05d', (int)$lastOrderNumber + 1);
                $orderCode = $dateCode . $nextOrderNumber;
            }

            return $orderCode;
        }

    public function scopeIsActive(Builder $builder) {
        return $builder->where('is_active', 1);
    }

    public function isUserCabang(){
        return !is_null($this->namacabang());
    }
    public function isAdmin(){
         $users = Auth::user()->id;
          return $users;
    }


}
