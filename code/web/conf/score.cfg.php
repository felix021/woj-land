<?php

final class score_conf {

    //在数据库中的区分（固定）
    const EASY              = 1;
    const MEDIUM            = 3;
    const DIFFICULT         = 5;

    //实际的分值（可调整）
    const EASY_SCORE        = 1;
    const MEDIUM_SCORE      = 3;
    const DIFFICULT_SCORE   = 5;

    //不同题型的累计分值上限
    const EASY_LIMIT        = 40;
    const MEDIUM_LIMIT      = 40;
    const DIFFICULT_LIMIT   = 20;
}

?>
