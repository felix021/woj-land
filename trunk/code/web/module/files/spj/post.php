<?php

class Main extends acframe
{

    protected $need_session = true;
    protected $need_login   = true;

    public function process()
    {
        $p = request::$arr_post;
        $seed = session::get_vcode();
        if (false === $seed || $seed != $p['seed'])
        {
            throw new Exception("Seed not set, please try again.");
        }

        FM_LOG_TRACE('%s', print_r($p, true));
        $pid = (int)$p['problem_id'];
        if ($pid <= 0)
        {
            throw new Exception('No problem_id provided.');
        }

        $data_prefix = wrapper_conf::DATA_PATH . '/' . $pid . '/';
        if (!is_dir($data_prefix)) @mkdir($data_prefix);
        $spj_src_cpp = $data_prefix . 'spj.cpp';
        if (!move_uploaded_file($_FILES['spj']['tmp_name'], $spj_src_cpp))
        {
            FM_LOG_WARNING("move_uploaded_file failed");
            throw new Exception("Upload spj failed.");
        }

        $spj_exe     = $data_prefix . 'spj.exe';
        $cmd = "g++ -O2 -Wall -Wno-unused-result -o $spj_exe $spj_src_cpp 2>&1";
        FM_LOG_TRACE("cmd: %s", $cmd);

        $ret = -1;
        $output = null;
        exec($cmd, $output, $ret);

        if ($ret == 0 && file_exists($spj_exe))
        {
            response::display_msg('Upload spj.exe succeeded');
        }
        else
        {
            throw new Exception ('Failed: ' . join(';', $output));
        }

        return true;
    }

    public function display()
    {
        return true;
    }
}

?>
