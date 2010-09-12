<?php

$noah = new mysqli('localhost', 'root', '123456', 'noah');
$noah->set_charset('GBK');
$land = new mysqli('localhost', 'root', '123456', 'land');
$land->set_charset('UTF8');

$sql = 'SELECT * FROM `problem` ORDER BY `problem_id`';

$result = $noah->query($sql);
if ($noah->errno) {
    die('NOAH: ' . $noah->error . ': ' . $noah->error);
}

$sql = 'TRUNCATE `problems`';
$land->query($sql);
if ($land->errno) {
    die('LAND:' . $land->error . ': ' . $land->error);
}

while ($row = $result->fetch_assoc()) {
    $row['description'] = str_replace("\n", "<br/>", $row['description']);
    //$row['hint'] = str_replace("\n", "<br/>", $row['hint']);
    //$row['input']       = str_replace("\n", "<br/>", $row['input']);
    //$row['output']      = str_replace("\n", "<br/>", $row['output']);
    foreach ($row as $key => &$value) 
    {
        //$value = trim($value);
        $value = decode_html($value);
        $value = $land->real_escape_string($value);
    }
    extract($row, EXTR_PREFIX_ALL, 'R');
    $sql = <<<eot
INSERT INTO `problems` 
(problem_id, title, description, input, output, sample_input, sample_output, hint, source, time_limit, memory_limit, accepted, submitted, enabled) VALUES
('$R_problem_id', '$R_title', '$R_description', '$R_input', '$R_output', '$R_sample_input', '$R_sample_output', '$R_hint', '$R_source', '$R_time_limit', '$R_memory_limit', '$R_accepted', '$R_submit', '1')
eot;
    $land->query($sql);
    if ($land->errno) {
        die('LAND:' . $land->error . ': ' . $land->error . '\n'. $sql);
    }
}

function decode_html(&$s) {
    $s = html_entity_decode($s, ENT_NOQUOTES, 'utf-8');
    return $s;
}
?>
