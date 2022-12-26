<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class DataJalurPendaftaran extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    protected static $unguarded = true;

    protected static function getJalurPendaftarans ()
    {
        return Cache::rememberForever('jalur_pendaftarans', fn () => DataJalurPendaftaran::all());
    }

    public static function getJalurPendaftaran($id)
    {
        return static::getJalurPendaftarans()[$id-1];
    }

    protected static function concateJalur($jalur)
    {
        $opt = $jalur->jalur;
        if (isset($jalur->subjalur)) $opt .= ' ' . $jalur->subjalur;
        return $opt;
    }

    public static function getOptions ()
    {
        $jalur_pendaftarans = static::getJalurPendaftarans();
        $result = [];
        
        foreach ($jalur_pendaftarans as $jalur) {
            if ($jalur->subjalur) continue;
        
            $opt = static::concateJalur($jalur);
            $result[] = [
                'label' => strtoupper($opt),
                'value' => $jalur->id
            ];
        } return $result;
    }

    public static function getPrestasiOptions ()
    {
        $jalur_pendaftarans = static::getJalurPendaftarans();
        $opts = [['label' => '-- Pilih Prestasi --', 'value' => '']];

        foreach ($jalur_pendaftarans as $jalur) {
            if (!$jalur->subjalur) continue;

            $opt = static::concateJalur($jalur);
            $opts[] = [
                'label' => strtoupper($opt),
                'value' => $jalur->id
            ];
        } return $opts;
    }

    public static function getAdvancedOptions()
    {
        $jalur_pendaftarans = static::getJalurPendaftarans();
        $result = [['label' => '-- Pilih Jalur Pendaftaran --', 'value' => '']];
        foreach ($jalur_pendaftarans as $jalur) {
            $opt = static::concateJalur($jalur);

            $result[] = [
                'label' => strtoupper($opt),
                'value' => $jalur->id
            ];
        } return $result;
    }

    public static function getFormInput (Identitas $data = null) :array
    {
        $data ??= [];
        $jalurs = Cache::rememberForever('jalur_pendaftaran_options', fn() => static::getOptions());
        $jalurprestasi = static::getPrestasiOptions();

        return [
            ['type' => 'radio', 'name' => 'jalur_pendaftaran_id', 'value' => $data['jalur_pendaftaran_id']??null,
                'label' => 'Jalur Pendaftaran', 'values' => $jalurs, 'opts' => ['required']],
            ['variant' => 'nolabelkeepcol', 'type' => 'select', 'name' => 'sub_jalur_pendaftaran_id', 'value' => $data['jalur_pendaftaran_id']??old('sub_jalur_pendaftaran_id')??old('jalur_pendaftaran_id')??null,
                'label' => null, 'placeholder' => null, 'options' => $jalurprestasi],
        ];
    }
}
