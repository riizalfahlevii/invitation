<?php
    // require "../config.php";
    require "config.php";

    try {
        if (!empty($_POST)) {
            $row = R::dispense("guests");
            $row->name = $post_form_name;
            $row->kehadiran = $post_form_presence;
            $row->jumlah = $post_form_count;
            $row->ucapan = $post_form_comment;
            $row->input = date("Y-m-d H:i:s");
            $check = R::store($row);
            if ($check) {
                response("Terima kasih atas ucapan yang diberikan. Kami mohon doanya agar acara dapat berlangsung dengan lancar tanpa kurang suatu apapun.", true, R::getall("select * from guests order by id desc"));
            } else {
                response("Failed", false);
            }
        } else {
            response("success", true, R::getall("select * from guests order by id desc"));
        }
    } catch (Exception $e) {
        response("Error: " . $e->getMessage(), false);
    }

    // function feedback($tahun = 0) {
    //     $agenda = R::getrow("SELECT agenda FROM undangan where year(tgl_terima) = ".($tahun == 0 ? "year(now())" : " $tahun")." order by year(tgl_terima) desc, agenda desc LIMIT 1");
    //     response("Success", true, array(
    //     "agenda" => $agenda == null ? 1 : $agenda['agenda'] + 1,
    //     "tahun" => R::getall("SELECT YEAR(tgl_terima) tahun, COUNT(*) jumlah FROM undangan GROUP BY YEAR(tgl_terima)"),
    //     "all_tahun" => R::getrow("SELECT COUNT(*) jumlah FROM undangan")['jumlah'],
    //     "surat" => R::getall("select * from undangan ".($tahun == 0 ? "" : "where year(tgl_terima) = $tahun")." order by year(tgl_terima) desc, agenda desc")
    //     ));
    // }

?>
