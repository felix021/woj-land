<?php

class Main extends acframe
{

    protected $need_session = true;
    protected $need_login   = true;

    public function process()
    {
        $p = request::$arr_post;
        FM_LOG_TRACE('%s', print_r($p, true));
        $pid = (int)$p['problem_id'];
        if ($pid <= 0)
        {
            throw new Exception('No problem_id provided.');
        }

        $file = $p['file'];
        if (empty($file))
            throw new Exception('No file provided.');

        $data_txt = wrapper_conf::DATA_PATH . '/' . $pid . '/data.txt';
        $in_file  = wrapper_conf::DATA_PATH . '/' . $pid . '/' . $file . '.in';
        $out_file = wrapper_conf::DATA_PATH . '/' . $pid . '/' . $file . '.out';
        if (is_readable($data_txt))
        {
            $files = file($data_txt);
            $newfile = '';
            foreach ($files as $f)
            {
                $f = trim($f);
                $f = str_replace('.in', '', $f);
                if ($f != $file)
                {
                    $newfile .= "$f\n";
                }
            }

            FM_LOG_TRACE('new file: %s', $newfile);
            if (is_writeable($data_txt))
            {
                if (strlen($newfile) == file_put_contents($data_txt, $newfile))
                {
                    unlink($in_file);
                    unlink($out_file);
                    response::add_data('msg', "file $file.in $file.out deleted");
                }
                else
                {
                    FM_LOG_WARNING('write to data.txt failed');
                    throw new Exception('write failed');
                }
            }
            else
            {
                response::add_data('msg', 'data.txt not writeable');
            }
        }
        return true;
    }

    public function display()
    {
        $this->set_my_tpl('delete.tpl.php');
        return true;
    }
}

?>
