<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Link
 *
 * @property int $id
 * @property string|null $link
 * @property string|null $token
 * @property int $uid
 * @property int $count
 * @property \Carbon\Carbon|null $date
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Link whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Link whereLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Link whereToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Link whereUid($value)
 * @mixin \Eloquent
 */

class Link extends Model
{
    public $timestamps = false;
    
    protected $table = 'links';
    protected $fillable = [
        'link',
        'token',
        'count',
        'uid'
    ];
}