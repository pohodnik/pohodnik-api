<?php

function compareBounds($boxA, $boxB) {
    $xA = max($boxA[0], $boxB[0]);
    $yA = max($boxA[1], $boxB[1]);
    $xB = min($boxA[2], $boxB[2]);
    $yB = min($boxA[3], $boxB[3]);


    $interArea = abs(max($xB - $xA, 0) * max($yB - $yA, 0));
    if ($interArea == 0) {
        return 0;
    }

    $boxAArea = abs(($boxA[2] - $boxA[0]) * ($boxA[3] - $boxA[1]));
    $boxBArea = abs(($boxB[2] - $boxB[0]) * ($boxB[3] - $boxB[1]));

    $iou = $interArea / ($boxAArea + $boxBArea - $interArea);

    return $iou;
}
