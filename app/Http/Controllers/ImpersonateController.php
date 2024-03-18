<?php

namespace App\Http\Controllers;

use App\Models\Scopes\CompanyScope;
use App\Models\User;
use Illuminate\Http\Request;

class ImpersonateController extends Controller
{
    public function impersonate($user_id)
    {
        $originalId = auth()->user()->id;
        session()->put('impersonate', $originalId);

        auth()->loginUsingId($user_id);

        return redirect()->route('clients.index');
    }

    public function leaveImpersonating()
    {
        if (!session()->has('impersonate'))
        {
            abort(403);
        }
        auth()->login(User::find(session('impersonate')));
        session()->forget('impersonate');
        session()->forget('company_id');
        return redirect()->route('clients.index');
    }
}
