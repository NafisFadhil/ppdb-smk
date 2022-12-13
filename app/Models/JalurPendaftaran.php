<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class JalurPendaftaran extends Model
{
    // use HasFactory;

    public $timestamps = false;

    private function uppercaseAttribute() :Attribute {
        return Attribute::make(
            get: fn ($value) => strtoupper($value),
            set: fn ($value) => strtoupper($value),
        );
    }
    protected function jalur() :Attribute {
        return $this->uppercaseAttribute();
    } 
    protected function subjalur1() :Attribute {
        return $this->uppercaseAttribute();
    } 
    protected function subjalur2() :Attribute {
        return $this->uppercaseAttribute();
    } 
    

    public function identitases () {
        return $this->hasMany(Identitas::class);
    }

    public static function getOptions()
    {
        $jalurs = JalurPendaftaran::all();
        $result = [];
        
        foreach ($jalurs as $jalur) {
            if ($jalur->subjalur1) continue;
        
            $opt = $jalur->jalur;
            $result[] = [
                'label' => strtoupper($opt),
                'value' => $jalur->id
            ];
        } return $result;
    }

    public static function getAdvancedOptions()
    {
        $jalurs = JalurPendaftaran::all();
        $result = [['label' => '--Pilih Jalur Pendaftaran--', 'value' => '']];
        foreach ($jalurs as $jalur) {
            $opt = $jalur->jalur;
            if (isset($jalur->subjalur1)) $opt .= ' ' . $jalur->subjalur1;
            if (isset($jalur->subjalur2)) $opt .= ' ' . $jalur->subjalur2;

            $result[] = [
                'label' => strtoupper($opt),
                'value' => $jalur->id
            ];
        } return $result;
    }

}
