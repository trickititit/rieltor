<?php
/**
 * Created by PhpStorm.
 * User: Трик
 * Date: 07.08.2016
 * Time: 17:27
 */


require_once "object_class.php";
require_once "export/PHPExcel.php";
require_once "user_class.php";

class Export {

    private $objects;
    private $user;
    private $user_info;

    public function __construct($db)
    {
        session_start();
        $this->objects = new Object($db);
        $this->user = new User($db);
        $this->user_info = $this->getUser();        
    }

    private function getUser(){
        $login = $_SESSION["login"];
        $password = $_SESSION["password"];
        if ($this->user->checkUser($login, $password)) return $this->user->getUserOnLogin($login);
        else return false;
    }

    public function get_export() {
        $user_id = isset($_REQUEST['user_id']) ? $_REQUEST['user_id'] : '';
        $ROOT = $_SERVER['DOCUMENT_ROOT'];
            $xls = PHPExcel_IOFactory::load( $ROOT.'/lib/export/clear.xlsx' );
            if ($user_id == "") {
                $objs = $this->objects->getAll();
            } else {
                $objs = $this->objects->getMy($user_id);
            }
            $count = array(
                '0' => 2
            , '1' => 2
            , '2' => 2
            , '3' => 2
            , '4' => 2
            , '5' => 2
            , '6' => 2
            );
            if ($objs == "") return false;

            foreach ( $objs as $post ) {
                if ($post["obj_rooms"] == "Студия") $post["obj_rooms"] = "0";
                $post["obj_rooms"] += 1;
                // Field Area
                $area = $post["obj_area"];
                $area = str_replace( 'микрорайон', 'мкр.', $area);
                $area = str_replace( 'Квартал', 'Кв-л', $area);

                // Field Street
                $street = $post['obj_address']."\r\n".$post['obj_floor']."/".$post['obj_home_floors']. " этаж, ".$post['obj_square']. " м²";
                $street_h = $post['obj_address']."\r\n".$post['obj_home_floors']." этаж, ".$post['obj_house_square']. " м²";


                // Field Price
                $price = number_format( $post['obj_price'] );

                // Field Desc
                $desc = strip_tags( $post['obj_desc'] );

                // Field Doplata
                $doplata = number_format( $post['obj_doplata'] );

                // Field Comments
                $comm = strip_tags( $post['obj_desc_short'] );

                // Field Contacts
                $cont = strip_tags( $post['obj_client_contact'] );

                // Field Date
                $date = $this->formantDate($post["date"]);

                if ( $post['obj_category'] == '1' ) {

                    $xls->setActiveSheetIndex( $post["obj_rooms"] )
                        ->setCellValue('A'.$count[ $post["obj_rooms"] ], $area)
                        ->setCellValue('B'.$count[ $post["obj_rooms"] ], $street)
                        ->setCellValue('C'.$count[ $post["obj_rooms"] ], $price)
                        ->setCellValue('D'.$count[ $post["obj_rooms"] ], $desc)
                        ->setCellValue('E'.$count[ $post["obj_rooms"] ], $doplata)
                        ->setCellValue('F'.$count[ $post["obj_rooms"] ], $comm)
                        ->setCellValue('G'.$count[ $post["obj_rooms"] ], $cont)
                        ->setCellValue('H'.$count[ $post["obj_rooms"] ], $date);

                    // Colored row

                    if ( $count[$post["obj_rooms"]]%2 == 0 ) {

                        $xls->getActiveSheet()
                            ->getStyle('A'.$count[$post["obj_rooms"]].':H'.$count[$post["obj_rooms"]])
                            ->getFill()
                            ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                            ->getStartColor()
                            ->setRGB('c6e0b4');
                    } else {

                        $xls->getActiveSheet()
                            ->getStyle('A'.$count[$post["obj_rooms"]].':H'.$count[$post["obj_rooms"]])
                            ->getFill()
                            ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                            ->getStartColor()
                            ->setRGB('e2efda');
                    }

                    $count[$post["obj_rooms"]]++;

                }

                if ( $post['obj_category'] == '3' ) {

                    $xls->setActiveSheetIndex(0)
                        ->setCellValue('A'.$count["0"], $area)
                        ->setCellValue('B'.$count["0"], $street)
                        ->setCellValue('C'.$count["0"], $price)
                        ->setCellValue('D'.$count["0"], $desc)
                        ->setCellValue('E'.$count["0" ], $doplata)
                        ->setCellValue('F'.$count["0" ], $comm)
                        ->setCellValue('G'.$count["0" ], $cont)
                        ->setCellValue('H'.$count["0" ], $date);

                    // Colored row

                    if ( $count['0']%2 == 0 ) {

                        $xls->getActiveSheet()
                            ->getStyle('A'.$count["0"].':H'.$count["0"])
                            ->getFill()
                            ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                            ->getStartColor()
                            ->setRGB('c6e0b4');
                    } else {

                        $xls->getActiveSheet()
                            ->getStyle('A'.$count["0"].':H'.$count["0"])
                            ->getFill()
                            ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                            ->getStartColor()
                            ->setRGB('e2efda');
                    }

                    $count['0']++;
                }

                if ( $post['obj_category'] == '2' ) {

                    $xls->setActiveSheetIndex(6)
                        ->setCellValue('A'.$count["6"], $area)
                        ->setCellValue('B'.$count["6"], $street_h)
                        ->setCellValue('C'.$count["6"], $price)
                        ->setCellValue('D'.$count["6"], $desc)
                        ->setCellValue('E'.$count["6" ], $doplata)
                        ->setCellValue('F'.$count["6" ], $comm)
                        ->setCellValue('G'.$count["6" ], $cont)
                        ->setCellValue('H'.$count["6" ], $date);

                    // Colored row

                    if ( $count['6']%2 == 0 ) {

                        $xls->getActiveSheet()
                            ->getStyle('A'.$count["6"].':H'.$count["6"])
                            ->getFill()
                            ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                            ->getStartColor()
                            ->setRGB('c6e0b4');
                    } else {

                        $xls->getActiveSheet()
                            ->getStyle('A'.$count["6"].':H'.$count["6"])
                            ->getFill()
                            ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                            ->getStartColor()
                            ->setRGB('e2efda');
                    }

                    $count['6']++;
                }
            }


            // Border tables by sheet
            foreach( $count as $id => $c ) {

                $styleArray = array(
                    'borders' => array(
                        'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN,
                            'color' => array('rgb' => '000000'),
                        ),
                    ),
                );

                $xls->setActiveSheetIndex($id)
                    ->getStyle( 'A1:H'.($c-1) )
                    ->applyFromArray($styleArray);

                $xls->setActiveSheetIndex($id)
                    ->getStyle( 'A1:H'.($c-1) )
                    ->getAlignment()->setWrapText(true);
            }
            $xls->setActiveSheetIndex(0);
            $filename = $this->user_info["login"].'-'.date('d-m-Y');


            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="'.$filename.'.xlsx"');
            header('Cache-Control: max-age=0');
            header('Cache-Control: max-age=1');

            header ('Expires: '.gmdate('D, d M Y H:i:s').' GMT'); // Date in the past
            header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
            header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
            header ('Pragma: public'); // HTTP/1.0

            $objWriter = PHPExcel_IOFactory::createWriter( $xls, 'Excel2007' );
            $objWriter->save('php://output');

            exit;
        }

    private function formantDate($time) {
        return date("d-m-Y", $time);
    }
}