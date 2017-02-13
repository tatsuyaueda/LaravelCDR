<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\AddressBookGroup
 *
 * @property int $id
 * @property int $parent_groupid
 * @property int $type
 * @property int $owner_userid
 * @property string $group_name
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\AddressBookGroup[] $childs
 * @method static \Illuminate\Database\Query\Builder|\App\AddressBookGroup whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\AddressBookGroup whereGroupName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\AddressBookGroup whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\AddressBookGroup whereOwnerUserid($value)
 * @method static \Illuminate\Database\Query\Builder|\App\AddressBookGroup whereParentGroupid($value)
 * @method static \Illuminate\Database\Query\Builder|\App\AddressBookGroup whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\AddressBookGroup whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class AddressBookGroup extends Model {

    protected $guarded = ['id'];

    public function childs() {
        return $this->hasMany('App\AddressBookGroup', 'parent_groupid', 'id');
    }

}
