<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Kader\Kader;
use Illuminate\Http\Request;

class MembershipController extends Controller
{
    public function check(Request $request)
    {
        $nik = $request->input('nik');
        $kader = null;
        
        if ($nik) {
            $kader = Kader::where('nik', $nik)->first();
        }
        
        return view('front.membership.check', compact('kader', 'nik'));
    }
    
    public function verify(Request $request)
    {
        $request->validate([
            'nik' => 'required|string|size:16',
            'name' => 'required|string',
        ]);
        
        $kader = Kader::where('nik', $request->nik)
            ->where('name', 'like', '%' . $request->name . '%')
            ->first();
            
        return view('front.membership.status', compact('kader'));
    }
}