<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Cdr
 *
 * @property int $id
 * @property int $Type
 * @property string $Sender
 * @property string $Destination
 * @property string $StartDateTime
 * @property string $EndDateTime
 * @property int $Duration
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Cdr whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Cdr whereDestination($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Cdr whereDuration($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Cdr whereEndDateTime($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Cdr whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Cdr whereSender($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Cdr whereStartDateTime($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Cdr whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Cdr whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Cdr extends Model
{
    //
}
