<?php

namespace App\Models\Vinograd;

use App\Models\Blog\Post;
use App\Models\Vinograd\User;
use App\Models\Vinograd\UserComment;
use Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Comment extends Model
{
    use Notifiable;

    protected $table = 'vinograd_comments';
    public $timestamps = false;
    protected $fillable = ['text', 'product_id', 'post_id', 'parent_id'];

    //======== Relationships ================
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id');
    }

    public function parent()
    {
        return $this->belongsTo(static::class, 'parent_id', 'id');
    }

    public function children()
    {
        return $this->hasMany(static::class, 'parent_id', 'id');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function commentAuthor()
    {
        return $this->belongsTo(UserComment::class, 'user_coment');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 0);
    }

    public static function add($fields, $user_comment = 0)
    {
        $comment = new static;
        $comment->fill($fields);
        $comment->date_coment = time();
        $comment->user_id = Auth::check() ? Auth::user()->id : 0;
        $comment->status = is_admin() ? 0 : 1;
        $comment->user_coment = $user_comment;
        $comment->save();
        return $comment;
    }

    public function allow()
    {
        $this->status = 1;
        $this->save();
    }

    public function disAllow()
    {
        $this->status = 0;
        $this->save();
    }

    public function toggleStatus()
    {
        return ($this->status == 0) ? $this->allow() : $this->disAllow();
    }

    public function remove()
    {
        $this->delete();
    }

    public static function getNewCommentsCount($model)
    {
        $temp = self::where('status', 1)->whereNotNull($model)->get();
        return $temp->count();
    }

    public function getCildrenComments($id)
    {
        return $this->where(['status' => 0, 'parent_id' => $id])->get();
    }

    public static function getAllProductComments($id, $field_id = 'product_id')
    {
        $temps = self::with('author', 'commentAuthor')->where([$field_id => $id, 'status' => 0])->orderBy('id', 'asc')->get();
        foreach ($temps as $temp) {
            $temp->push($temp->author);
            $temp->push($temp->commentAuthor);
        }
        return getTree($temps->keyBy('id')->toArray());
    }

    public function routeNotificationForMail($notification)
    {
        //  Пока отдаем почту родителя. При необходимости доработать.
        return $this->parent->author ? $this->parent->author->email : $this->parent->commentAuthor->email;
    }
}
