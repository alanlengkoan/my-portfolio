<?php

/**
 * Laravel Dompdf Library
 *
 * Generate PDF's from HTML in Laravel
 *
 * @packge     Laravel
 * @subpackage Libraries
 * @category   Libraries
 * @author     Alan Saputra Lengkoan
 * @license    MIT License
 */

namespace App\Libraries;

use Dompdf\Dompdf;
use Dompdf\Options;

class Pdf
{
    // untuk cetak pdf
    public static function printPdf($file_name, $view, $size = 'A4', $measure = 'potrait', $data = [])
    {
        $options = new Options();
        $options->setChroot(public_path());
        
        $dompdf = new Dompdf();
        $html = view($view, $data)->render();
        $dompdf->setOptions($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper($size, $measure);
        $dompdf->render();
        $dompdf->stream($file_name . '.pdf', ['Attachment' => false]);
        exit(0);
    }
}