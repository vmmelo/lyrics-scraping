<?php

namespace App\Http\Controllers\Api;
use App\Models\S3Client;
use GuzzleHttp\Client;

use App\Vagalume;
use Illuminate\Http\Request;

class VagalumeController
{
    protected $Vagalume;

    public function __construct()
    {
        $this->Vagalume = new Vagalume();
    }

    public function getLyrics(Request $request, String $musicName)
    {
        $lyrics = $this->Vagalume->getLyrics($musicName);
        dd($musicName);
        return response()->json(['teste' => 'funcionando']);
    }

    protected function model()
    {
        return Vagalume::class;
    }

}
