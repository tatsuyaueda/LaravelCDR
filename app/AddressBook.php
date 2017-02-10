<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AddressBook extends Model {

    protected $guarded = ['id'];

    //
    public function GroupName() {

        $group = \App\AddressBookGroup::find($this->groupid);
        $groupName = $group->group_name;
        debug($group);

        while ($group->parent_groupid != 0) {
            $group = \App\AddressBookGroup::find($group->parent_groupid);
            $groupName = $group->group_name . " > " . $groupName;
            debug($group);
        }

        return $groupName;
    }

}
