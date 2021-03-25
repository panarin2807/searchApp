<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;

class UsersImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $usernameWithoutDash = str_replace('-', '', $row[1]);

        $password = substr($usernameWithoutDash, -6);

        $user = User::where('username', $row[1])->first();

        if ($user) {
            $user->prefix_id = $row[0];
            $user->fname = $row[2];
            $user->lname = $row[3];
            $user->username = $row[1];
            $user->email = $row[4];
            $user->password = Hash::make($password);
            $user->type = 0;
            $user->status = 1;
            $user->save();
            return null;
        }

        return new User([
            'prefix_id' => $row[0],
            'fname' => $row[2],
            'lname' => $row[3],
            'username' => $row[1],
            'email' => $row[4],
            'password' => Hash::make($password),
            'type' => 0,
            'status' => 1,
        ]);
    }
}
