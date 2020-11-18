<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class SpacialUnique implements Rule
{
    public $id;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */

    public function passes($attribute, $value)
    {

        if ($attribute == 'name') {
            $users = DB::table('users')->select('id', 'name')->get();

            for ($i = 0; $i < count($users); $i++) {
                if ($users[$i]->id == $this->id) {
                    continue;
                }

                if ($users[$i]->name == $value) {
                    return false;
                }
            }

            return true;
        } else if ($attribute == 'email') {
            $users = DB::table('users')->select('id', 'email')->get();

            for ($i = 0; $i < count($users); $i++) {
                if ($users[$i]->id == $this->id) {
                    continue;
                }

                if ($users[$i]->email == $value) {
                    return false;
                }
            }

            return true;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'This Field has already been taken.';
    }
}
