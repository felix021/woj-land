<?php

require_once(CONF_ROOT . '/score.cfg.php');

function get_score($easy, $medium, $difficult) {
    $score = 0;
    $score += min(score_conf::EASY_LIMIT, $easy * score_conf::EASY_SCORE);
    $score += min(score_conf::MEDIUM_LIMIT, $medium * score_conf::MEDIUM_SCORE);
    $score += min(score_conf::DIFFICULT_LIMIT, $difficult * score_conf::DIFFICULT_SCORE);
    return $score;
}

?>
