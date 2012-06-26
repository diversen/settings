<?php

class settingsMeta {
    
    public $errors = array ();
    public function form () {
        
        $res = config::getMainIni('meta_robots');
        if ($res == 'noindex, nofollow') {
            $set = 0;
        } else {
            $set = 1;
        }
        
        $init = array ('meta_robots' => $set);
        $f = new html();
        $f->init($init, 'robots_submit');
        $f->formStart();
        
        $rows = array (
            
            array (
                'id' => 0,
                'title' => lang::translate('settings_meta_in_visible_for_robots')
            ),
            
            array (
                'id' => 1,
                'title' => lang::translate('settings_meta_visible_for_robots')
            ),
            
        );
        $f->legend(lang::translate('settings_robots_legend'));
        $f->select('meta_robots', $rows, 'title', 'id');
        $f->submit('robots_submit', lang::system('submit'));
        $f->formEnd();
        
        echo $f->getStr();
    }
    
    /**
     * 
     */
    public function validate () {
        
    }
    
    public function update () {
       // $c = new configdb();
        //print_r($_POST); die;
        if ($_POST['meta_robots'] == 1) {
           //die;
            configdb::set('meta_robots', '', 'main');

        }
        
        if ($_POST['meta_robots'] == 0) {
            
            configdb::set('meta_robots', 'noindex, nofollow', 'main');
        }
    }
}
