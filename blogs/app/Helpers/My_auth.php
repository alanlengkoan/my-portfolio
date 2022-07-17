<?php

use App\Models\User;

if (!function_exists('checking_role_session')) {
    function checking_role_session($session, $has_roles, $roles = 'users')
    {
        if ($has_roles) {
            $users = get_users_detail($session['id_users']);
            if ($users->roles !== $roles) {
                return redirect()->away('/' . $users->roles)->send();
            }
        }
    }
}

if (!function_exists('detect_role_session')) {
    function detect_role_session($session, $has_roles, $roles)
    {
        // untuk cek session
        if ($has_roles && checking_session($session)) {
            // untuk roles user
            checking_role_session($session, $has_roles, $roles);
        }
        return redirect('/');
    }
}

if (!function_exists('checking_session')) {
    function checking_session($session)
    {
        $users  = get_users_detail($session['id_users']);
        $roles  = get_roles();
        $search = in_array($users->roles, $roles);
        if ($search === false) {
            return false;
        }
        return true;
    }
}

if (!function_exists('get_users_detail')) {
    function get_users_detail($id)
    {
        $users = User::find($id);
        if ($users) {
            return $users;
        }
    }
}

if (!function_exists('get_roles')) {
    function get_roles()
    {
        $users = User::select('roles')->groupBy('roles')->get();
        $roles = [];
        if ($users) {
            foreach ($users as $value) {
                $roles[] = $value->roles;
            }
        }
        return $roles;
    }
}
