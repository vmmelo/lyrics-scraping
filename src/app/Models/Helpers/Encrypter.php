<?php


namespace App\Models\Helpers;


class Encrypter
{

    protected $encrypter;
    protected $key;
    protected $cipher;

    public function __construct()
    {
        $this->key = base64_decode(env('MOLA_CRYPT_KEY', 'ZsByBqeuv5XF2SnIkbuKCswRT8n8ZCS1BXQDDhL40Ac='));
        $this->cipher = env('MOLA_CRYPT_CIPHER', 'AES-256-CBC');

        $this->encrypter = new \Illuminate\Encryption\Encrypter($this->key, $this->cipher);
    }

    public function decrypt($string, $unserialize = false)
    {
        return $this->encrypter->decrypt($string, $unserialize);
    }

    public function encrypt($string)
    {
        return $this->encrypter->encryptString($string);
    }

}
