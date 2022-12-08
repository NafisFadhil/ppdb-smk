<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JalurPendaftaran extends Model
{
    // use HasFactory;

    public $timestamps = false;

    public function identitases () {
        return $this->hasMany(Identitas::class);
    }

    public static function getOptions()
    {
        $jalurs = JalurPendaftaran::all();
        $result = [];
        
        foreach ($jalurs as $jalur) {
            if (isset($jalur->subjalur1)) continue;
        
            $opt = $jalur->jalur;
            if (isset($jalur->subjalur1)) {
                $opt .= ' ' . $jalur->subjalur1;
            } $result[] = ['label' => $opt, 'value' => $jalur->id];
        } return $result;
    }

    public static function getAdvancedOptions()
    {
        $jalurs = JalurPendaftaran::all();
        $result = [['label' => '--Pilih Jalur Pendaftaran--', 'value' => '']];
        foreach ($jalurs as $jalur) {
            $opt = $jalur->jalur;
            if (isset($jalur->subjalur1)) {
                $opt .= ' ' . $jalur->subjalur1;
            } if (isset($jalur->subjalur2) && isset($jalur->subjalur3)) {
                $opt .= ' (' . $jalur->subjalur2 . ' Tingkat ' . $jalur->subjalur3 .')';
            } $result[] = ['label' => $opt, 'value' => $jalur->id];
        } return $result;
    }
    
}
