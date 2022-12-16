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

    protected static $jalurs = [];

    protected static function initJalurs ()
    {
        if (empty(self::$jalurs)) {
            self::$jalurs = JalurPendaftaran::all();
        }
    }

    protected static function concateJalur($jalur)
    {
        $opt = $jalur->jalur;
        if (isset($jalur->subjalur1)) $opt .= ' ' . $jalur->subjalur1;
        if (isset($jalur->subjalur2)) $opt .= ' ' . $jalur->subjalur2;
        return $opt;
    }

    public static function getOptions ()
    {
        self::initJalurs();
        $result = [];
        
        foreach (self::$jalurs as $jalur) {
            if ($jalur->subjalur1) continue;
        
            $opt = self::concateJalur($jalur);
            $result[] = [
                'label' => strtoupper($opt),
                'value' => $jalur->id
            ];
        } return $result;
    }

    public static function getPrestasiOptions ()
    {
        self::initJalurs();
        $opts = [['label' => '--Pilih Prestasi--', 'value' => '']];

        foreach (self::$jalurs as $jalur) {
            if (!$jalur->subjalur1) continue;

            $opt = self::concateJalur($jalur);
            $opts[] = [
                'label' => strtoupper($opt),
                'value' => $jalur->id
            ];
        } return $opts;
    }

    public static function getAdvancedOptions()
    {
        self::initJalurs();
        $result = [['label' => '--Pilih Jalur Pendaftaran--', 'value' => '']];
        foreach (self::$jalurs as $jalur) {
            $opt = self::concateJalur($jalur);

            $result[] = [
                'label' => strtoupper($opt),
                'value' => $jalur->id
            ];
        } return $result;
    }

    public static function getFormInput ($req = null) :array
    {
        $req ?? [];
        $jalurs = JalurPendaftaran::getOptions();
        $jalurprestasi = JalurPendaftaran::getPrestasiOptions();

        return [
            ['type' => 'radio', 'name' => 'jalur_pendaftaran_id', 'value' => $req['jalur_pendaftaran_id']??null,
                'label' => 'Jalur Pendaftaran', 'values' => $jalurs, 'opts' => ['required']],
            ['variant' => 'nolabelkeepcol', 'type' => 'select', 'name' => 'sub_jalur_pendaftaran_id', 'value' => $req['sub_jalur_pendaftaran_id']??null,
                'label' => null, 'placeholder' => null, 'options' => $jalurprestasi],
        ];
    }

}
