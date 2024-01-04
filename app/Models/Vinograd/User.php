<?php

namespace App\Models\Vinograd;

use App\Models\Blog\Post;
use App\Models\Vinograd\Order\Order;
use Illuminate\Support\Facades\Storage;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use Notifiable;

    const IS_BANNED = 1;
    const IS_ACTIVE = 0;

    public $timestamps = false;

    protected $fillable = [
        'name', 'email', 'delivery'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'delivery' => 'array'
    ];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function wishlistItems()
    {
        return $this->hasMany(WishlistItem::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function isWait()
    {
        return $this->status === self::IS_BANNED;
    }

    public function isActive()
    {
        return $this->status === self::IS_ACTIVE;
    }

    public function verify()
    {
        if (!$this->isWait()) {
            throw new \DomainException('Пользователь уже подтвержден.');
        }
        $this->status = self::IS_ACTIVE;
        $this->verify_token = null;
        $this->save();
    }

    public static function add($fields)
    {
        $user = new static;
        $user->fill($fields);
        $user->password = bcrypt($fields['password']);
        $user->regdate = time();
        $user->verify_token = Str::random(20);
        $user->status = self::IS_BANNED;
        $user->save();

        return $user;
    }


    public function edit($fields)
    {
        $this->fill($fields);
        $this->save();
    }

    public function generatePassword($password)
    {
        if($password != null)
        {
            $this->password = bcrypt($password);
            $this->save();
        }
    }

    public function remove()
    {
        $this->removeAvatar();
        $this->delete();
    }

    public function uploadAvatar($image)
    {
        if($image == null) { return; }

        $this->removeAvatar();

        $filename = STR::random(10) . '.' . $image->extension();
        $image->storeAs('img/avatar/', $filename);
        $this->avatar = $filename;
        $this->save();
    }

    public function removeAvatar()
    {
        if($this->avatar != null)
        {
            Storage::delete('img/avatar/' . $this->avatar);
        }
    }

    public function getImage()
    {
        return $this->avatar == null ? '/img/user_default.png' : '/img/avatar/' . $this->avatar;
    }

    public function ban()
    {
        $this->status = User::IS_BANNED;
        $this->save();
    }

    public function unban()
    {
        $this->status = User::IS_ACTIVE;
        $this->save();
    }

    public function toggleBan($value)
    {
        return $value == null ? $this->unban() : $this->ban();
    }
}
