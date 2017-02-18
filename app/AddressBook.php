<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\AddressBook
 *
 * @property int $id
 * @property int $type
 * @property int $owner_userid
 * @property int $groupid
 * @property string $position
 * @property string $name_kana
 * @property string $name
 * @property string $tel1
 * @property string $tel2
 * @property string $tel3
 * @property string $email
 * @property string $comment
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\AddressBook whereComment($value)
 * @method static \Illuminate\Database\Query\Builder|\App\AddressBook whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\AddressBook whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\AddressBook whereGroupid($value)
 * @method static \Illuminate\Database\Query\Builder|\App\AddressBook whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\AddressBook whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\AddressBook whereNameKana($value)
 * @method static \Illuminate\Database\Query\Builder|\App\AddressBook whereOwnerUserid($value)
 * @method static \Illuminate\Database\Query\Builder|\App\AddressBook wherePosition($value)
 * @method static \Illuminate\Database\Query\Builder|\App\AddressBook whereTel1($value)
 * @method static \Illuminate\Database\Query\Builder|\App\AddressBook whereTel2($value)
 * @method static \Illuminate\Database\Query\Builder|\App\AddressBook whereTel3($value)
 * @method static \Illuminate\Database\Query\Builder|\App\AddressBook whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\AddressBook whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class AddressBook extends Model
{

    protected $guarded = ['id'];

    //
    public function GroupName()
    {

        $group = \App\AddressBookGroup::find($this->groupid);

        if (!$group) {
            return '';
        }

        $groupName = $group->group_name;

        while ($group->parent_groupid != 0) {
            $group = \App\AddressBookGroup::find($group->parent_groupid);
            $groupName = $group->group_name . " > " . $groupName;
        }

        return $groupName;

    }

}
