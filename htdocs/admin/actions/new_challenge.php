<?php

require('../../../include/mellivora.inc.php');

enforce_authentication(CONST_USER_CLASS_MODERATOR);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    validate_xsrf_token($_POST[CONST_XSRF_TOKEN_KEY]);

    if ($_POST['action'] == 'new') {
        $i=1;
        while(array_key_exists('flag_'.$i,$_POST)){
            $flags[] = $_POST['flag_'.$i];
            $i++;
        }
       $id = db_insert(
          'challenges',
          array(
             'added'=>time(),
             'added_by'=>$_SESSION['id'],
             'title'=>$_POST['title'],
             'description'=>$_POST['description'],
             'automark'=>$_POST['automark'],
             'case_insensitive'=>$_POST['case_insensitive'],
             'points'=>$_POST['points'],
             'category'=>$_POST['category'],
             'num_attempts_allowed'=>$_POST['num_attempts_allowed'],
             'min_seconds_between_submissions'=>$_POST['min_seconds_between_submissions'],
             'available_from'=>strtotime($_POST['available_from']),
             'available_until'=>strtotime($_POST['available_until'])
          )
       );

       if ($id) {
           foreach($flags as $flag){
                $flag_id = db_insert('flags',array(
                    'challenges_id'=>$id,
                    'flag'=>$flag
                ));
                if(!$flag_id){
                    message_error('Could not insert flag into DB');
                }
           }
           redirect(CONFIG_SITE_ADMIN_RELPATH . 'edit_challenge.php?id='.$id);
       } else {
          message_error('Could not insert new challenge.');
       }
    }
}
