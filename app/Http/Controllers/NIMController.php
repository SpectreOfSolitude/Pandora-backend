<?php

namespace App\Http\Controllers;

use App\Mail\tokenMail;
use App\Models\NIMModel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;


class NIMController extends Controller
{
    public function inputNIM(Request $request)
    {
        Log::info('API hit: Mahasiswa index');
        $request->validate([
            'nim' => 'required',
        ]);

        $nim = $request->input('nim');

        $mahasiswa = NIMModel::where('nim', $nim)->first();

        error_log($mahasiswa);
        error_log($nim);

        if ($mahasiswa) {
            $randomString = Str::random(6);
            $mahasiswa->token = $randomString;

            $details = [
                'title' => 'Token PEMILIHAN RAYA',
                'body' => $randomString,
            ];
    
            Mail::to('parasmagroup@gmail.com')->send(new tokenMail($details));

            $mahasiswa->save();
        } 
        else {
            return redirect()->route('mahasiswa.index')->with('error', 'Mahasiswa not found.');
        }
    }
}
