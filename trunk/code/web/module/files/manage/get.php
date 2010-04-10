<?php

class Main extends acframe
{

    protected $need_session = true;
    protected $need_login   = true;

    public function process()
    {
        $problem_id = (int)request::$arr_get['problem_id'];
        response::add_data('problem_id', $problem_id);

        $data_txt = wrapper_conf::DATA_PATH . '/' . $problem_id . '/data.txt';

        $files = array();
        if (is_readable($data_txt))
        {
            $files    = file($data_txt);
            foreach ($files as &$file)
            {
                $file = trim($file);
                if (empty($file)) 
                {
                    unset($file);
                    continue;
                }
                $file = str_replace(".in", "", $file);
            }
        }

        response::add_data('files', $files);
        response::add_data('seed', session::gen_vcode());

        return true;
    }

    public function display()
    {
        $this->set_my_tpl("manage.tpl.php");
        return true;
    }
}

?>
