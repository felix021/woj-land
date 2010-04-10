<?php

class Main extends acframe
{

    protected $need_session = true;
    protected $need_login   = true;

    public function process()
    {
        $p = request::$arr_post;
        $pid = (int)$p['problem_id'];
        if ($pid <= 0)
        {
            throw new Exception('No problem_id provided.');
        }

        FM_LOG_TRACE('%s', print_r($_FILES, true));

        $data_prefix = wrapper_conf::DATA_PATH . '/' . $pid . '/';

        if (!file_exists($data_prefix))
            mkdir($data_prefix);

        if (!file_exists($data_prefix))
            throw new Exception("Can't create data dir %s", $data_prefix);

        $data_txt = $data_prefix . 'data.txt';

        $new_data = array();
        if (file_exists($data_txt))
        {
            $new_data = file($data_txt);
        }
        else
        {
            file_put_contents($data_txt, '');
        }

        $new_data = array_filter($new_data, create_function('$a', '$a=trim($a); return !empty($a);'));
        foreach ($new_data as &$v) 
        {
            $v = trim($v);
        }

        $n_files = count($_FILES['input']['name']);
        for ($i = 0; $i < $n_files; $i++)
        {
            $in_f  = $_FILES['input']['name'][$i];
            $out_f = $_FILES['output']['name'][$i];
            if (empty($in_f) || empty($out_f)) continue;

            FM_LOG_TRACE('input: %s, output: %s', $in_f, $out_f);

            $in_dest  = $data_prefix . $in_f;
            $out_dest = $data_prefix . $out_f;

            if (!move_uploaded_file($_FILES['input']['tmp_name'][$i], $in_dest))
            {
                FM_LOG_WARNING("move file $in_f failed");
                throw new Exception("Move file $in_f failed");
            }

            if (!move_uploaded_file($_FILES['output']['tmp_name'][$i], $out_dest))
            {
                FM_LOG_WARNING("move file $out_f failed");
                throw new Exception("Move file $out_f failed");
            }

            $new_data[] = str_replace('.in', '', $in_f);
        }

        if (is_writeable($data_txt))
        {
            FM_LOG_DEBUG("before: %s", print_r($new_data, true));
            $new_data = array_unique($new_data);
            $data_str = join("\n", $new_data) . "\n";
            FM_LOG_DEBUG("after: %s", print_r($new_data, true));
            if (strlen($data_str) != file_put_contents($data_txt, $data_str))
            {
                FM_LOG_WARNING('%s write failed', $data_txt);
                throw new Exception('Write to data.txt failed');
            }
        }
        else
        {
            FM_LOG_WARNING('%s not writeable', $data_txt);
            throw new Exception('data.txt is not writeable');
        }

        response::display_msg('Upload succeeded');
        return true;
    }

    public function display()
    {
        return true;
    }
}

?>
