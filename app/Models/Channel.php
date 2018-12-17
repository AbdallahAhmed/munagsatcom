<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'channels';

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['since_update', 'user'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['sender_id', 'receiver_id'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function messages()
    {
        return $this->hasMany(Message::class, 'channel_id', 'id');
    }

    /**
     * Peer User of my channel
     * @return mixed
     */
    public function getUserAttribute()
    {
        if (fauth()->id() == $this->sender_id) {
            return User::find($this->receiver_id);
        } else {
            return User::find($this->sender_id);
        }
        return null;
    }

    /**
     * Since Updated time
     * @return mixed
     */
    public function getSinceUpdateAttribute()
    {
        return $this->updated_at->diffForHumans();
    }


    /**
     * Login user with this $userId
     * @param $query
     * @param $userId
     * @return mixed
     */
    public function scopeUser($query, $userId)
    {
        return $query->where(function ($query) use ($userId) {
            return $query->where(['sender_id' => fauth()->id(), 'receiver_id' => $userId]);
        })->Orwhere(function ($query) use ($userId) {
            return $query->where(['sender_id' => $userId, 'receiver_id' => fauth()->id()]);
        });
    }

}
