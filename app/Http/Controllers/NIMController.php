<?php

namespace App\Http\Controllers;

use App\Mail\tokenMail;
use App\Models\NIMModel;
use App\Models\Choice;
use App\Models\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
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
        
            if($mahasiswa->status_active) {

                $randomString = Str::random(6);
                $mahasiswa->token = $randomString;
    
                $details = [
                    'title' => 'Token PEMILIHAN RAYA',
                    'body' => $randomString,
                ];
        
                Mail::to('parasmagroup@gmail.com')->send(new tokenMail($details));
    
                $mahasiswa->save();

            } else {

                return redirect()->route('mahasiswa.index')->with('error', 'Mahasiswa not active.');

            }
        
        } else {
        
            return redirect()->route('mahasiswa.index')->with('error', 'Mahasiswa not found.');
        
        }
    }

    public function inputToken(Request $request) {
        $request->validate([
            'token' => 'required',
        ]);

        // ambil data token
        $token = $request->token;

        // validasi token (apakah terdapat mahasiswa bersangkutan yang menginputkannya atau tidak)
        $mahasiswa = NIMModel::where('token', $token)->first();
        if ($mahasiswa) {
        
            return response()->json(['nim' => $mahasiswa->nim]);
        
        } else {
        
            return response()->json(['error' => 'Token invalid'], 400);
        
        }
        
    }

    public function inputChoice(Request $request) {
        // ambil data choice
        $request->validate([
            'choice_id' => 'required',
            'nim' => 'required',
        ]);
        $choice_id = $request->choice_id;
        $nim = $request->nim;
        
        // validasi data choice
        $choice = Choice::where('id', $choice_id)->first();
        if(!$choice) {
            return response()->json(['error' => 'Pilihan tidak ditemukan'], 404);
        }

        // validasi data nim
        $mahasiswa = NIMModel::where('nim', $nim)->first();
        if(!$mahasiswa) {
            return response()->json(['error' => 'Mahasiswa tidak ditemukan'], 404);
        }

        // masukkan hasil voting ke table vote
        Vote::create([
            'choice_id' => $choice_id,
            'mahasiswa_id' => $mahasiswa->id,
        ]);

        if(!$mahasiswa->status_vote){
            // ubah status_vote mahasiswa jadi true
            $mahasiswa->status_vote = true;
    
            // ubah nim mahasiswanya menjadi hashing
            $mahasiswa->nim = Hash::make($mahasiswa->nim);
    
            // simpan hasil perubahan ke database
            $mahasiswa->save();

            return response()->json(['message' => 'Mahasiswa berhasil melakukan voting']);
        
        }else{
        
            return response()->json(['message' => 'Mahasiswa sudah melakukan voting sebelumnya']);
        
        }
        
    }
}
