<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

if (!function_exists('get_acak_id')) {
    function get_acak_id($table = NULL, $pk = NULL)
    {
        $id = 0;
        do {
            $id = rand();
        } while (!empty($table::where($pk, $id)->first()));
        return $id;
    }
}

if (!function_exists('get_kode_urut')) {
    function get_kode_urut($table, $key, $kd)
    {
        $result  = DB::select("SELECT MAX( SUBSTRING( $key,- 4)) AS kd FROM $table WHERE $key LIKE '%$kd%'");
        $kd_urut = $result[0]->kd;

        if ($kd_urut !== null) {
            $kode  = $kd_urut + 1;
            $add_k = str_pad($kode, 4, "0", STR_PAD_LEFT);
            return "{$kd}{$add_k}";
        } else {
            return "{$kd}0001";
        }
    }
}

if (!function_exists('remove_point_space')) {
    function remove_point_space($string)
    {
        return preg_replace('/\.|\s/', '', $string);
    }
}

if (!function_exists('generate_random_name_file')) {
    function generate_random_name_file($file)
    {
        return uniqid() . '-' . date('YmdHi') . '.' . $file->extension();
    }
}

if (!function_exists('tgl_indo')) {
    function tgl_indo($tgl)
    {
        if ($tgl == "0000-00-00") {
            return "-";
        } else {
            $tanggal = substr($tgl, 8, 2);
            $bulan   = get_bulan(substr($tgl, 5, 2));
            $tahun   = substr($tgl, 0, 4);

            return $tanggal . ' ' . $bulan . ' ' . $tahun;
        }
    }
}

if (!function_exists('get_bulan')) {
    function get_bulan($bln)
    {
        switch ($bln) {
            case 1:
                return "Januari";
                break;
            case 2:
                return "Februari";
                break;
            case 3:
                return "Maret";
                break;
            case 4:
                return "April";
                break;
            case 5:
                return "Mei";
                break;
            case 6:
                return "Juni";
                break;
            case 7:
                return "Juli";
                break;
            case 8:
                return "Agustus";
                break;
            case 9:
                return "September";
                break;
            case 10:
                return "Oktober";
                break;
            case 11:
                return "November";
                break;
            case 12:
                return "Desember";
                break;
        }
    }
}

if (!function_exists('get_waktu')) {
    function get_waktu($tgl)
    {
        return date("H : i : s", strtotime($tgl));
    }
}

if (!function_exists('random_color_part')) {
    function random_color_part()
    {
        return str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT);
    }
}

if (!function_exists('random_color')) {
    function random_color()
    {
        return random_color_part() . random_color_part() . random_color_part();
    }
}

if (!function_exists('remove_separator')) {
    function remove_separator($harga)
    {
        return str_replace('.', '', $harga);
    }
}

if (!function_exists('create_separator')) {
    function create_separator($harga)
    {
        return number_format($harga, 0, ',', '.');
    }
}

if (!function_exists('add_picture')) {
    function add_picture($request_img)
    {
        // nama
        $picture = generate_random_name_file($request_img);

        // upload
        $request_img->move(upload_path('picture'), $picture);

        return $picture;
    }
}

if (!function_exists('upd_picture')) {
    function upd_picture($request_img, $picture_name)
    {
        del_picture($picture_name);

        $picture = add_picture($request_img);

        return $picture;
    }
}

if (!function_exists('del_picture')) {
    function del_picture($picture_name)
    {
        $file_gambar = upload_path('picture/' . $picture_name);

        // hapus
        if (File::exists($file_gambar)) {
            File::delete($file_gambar);
        };
    }
}

if (!function_exists('count_array_index')) {
    function count_array_index($array, $index)
    {
        $sum = 0;
        foreach ($array as $row) {
            $count = count($row[$index]);
            $sum += ($count === 0 ? 1 : $count);
        }
        return $sum;
    }
}

if (!function_exists('sum_index')) {
    function sum_index($array, $index)
    {
        $sum = 0;
        foreach ($array as $row) {
            $sum += $row[$index];
        }
        return $sum;
    }
}