<?php

/**
 * UniSite CMS
 * @link    https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

namespace App\Systems\Doc;

class Doc
{

    public function pdf($template){
        global $app;

        $filename = $app->datetime->format("Y-m-d_H-i")->getDate() . '_' . uniqid();

        try {
            
            $mpdf = new \Mpdf\Mpdf(['tempDir' => $app->config->storage->temp]);
            $mpdf->ignore_invalid_utf8 = true;
            $template = mb_convert_encoding($template, 'UTF-8', 'UTF-8');
            $mpdf->WriteHTML($template);
            $mpdf->Output($app->config->storage->doc . '/' . $filename . '.pdf');

            return $app->config->storage->doc . '/' . $filename . '.pdf';

        } catch (Exception $e) {
            logger("Generate pdf: {$e->getMessage()}");
        }

    }

}