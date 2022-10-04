<?php
if($view->name == "encompass_exports") {
    //        dsm($view);
        print $view->result[0]->field_field_airing_channel[0]['rendered']['#title']."\n\r<br>";
        $month_name = $month_name = date("M", mktime(0, 0, 0, $view->exposed_input['field_airing_date_value']['value']['month'], 10));
               print $view->exposed_input['field_airing_date_value']['value']['day']."-".$month_name."-".$view->exposed_input['field_airing_date_value']['value']['year'];
                                                                    

    }
print $tbody; ?>
