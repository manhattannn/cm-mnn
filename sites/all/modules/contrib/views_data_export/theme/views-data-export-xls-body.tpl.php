<?php
if($view->name == "encompass_exports") {
    //        dsm($view);
    if ($view->result[0]->field_field_airing_channel[0]['rendered']['#title'] == "Channel 1") {
        print "MNN_SD1\n\r<br>";
    } 
    if ($view->result[0]->field_field_airing_channel[0]['rendered']['#title'] == "Channel 2") {
        print "MNN_SD2\n\r<br>";
    }
    if ($view->result[0]->field_field_airing_channel[0]['rendered']['#title'] == "Channel 3") {
        print "MNN_SD3\n\r<br>";
    }
    if ($view->result[0]->field_field_airing_channel[0]['rendered']['#title'] == "Channel 4") {
        print "MNN_SD4\n\r<br>";
    }
    if ($view->result[0]->field_field_airing_channel[0]['rendered']['#title'] == "Channel 5") {
        print "MNN_HD\n\r<br>";
    }            
    $month_name = $month_name = date("M", mktime(0, 0, 0, $view->exposed_input['field_airing_date_value']['value']['month'], 10));
               print $view->exposed_input['field_airing_date_value']['value']['day']."-".$month_name."-".$view->exposed_input['field_airing_date_value']['value']['year'];
                                                                    

    }
print $tbody; ?>
