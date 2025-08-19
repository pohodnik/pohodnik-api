<?php
    require_once("db.php");

    function boolByFlags($data, $flags) {
        foreach ($flags as $k) {
            if (!empty($k) && $data[$k] == '1') {
                return true;
            }
        }

        return false;
    }

    function getRulesForHiking($id_hiking, $id_user = null): array {

        $current_user = !empty($id_user) ? $id_user : $_COOKIE["user"];

        $rules = array(
            "full" => false,
            "all" => false,
            "routes" => false,
            "kitchen" => false,
            "health" => false,
            "media" => false,
            "time" => false,
            "equip" => false,
            "money" => false,
            "info" => false,
            "workouts" => false,
            "member" => false,
            "boss" => false,
        );

        if(!($id_hiking>0)){
            $rules['error'] = "has no id_hiking";
            $rules['error_details'] = $id_hiking;
            return $rules;
        }


        global $mysqli;

        $z = "
            SELECT
                hiking.id,
                hiking.id_author={$current_user} as is_author,
                (hiking_editors.is_cook=1) as is_cook,
                (hiking_editors.is_guide=1) as is_guide,
                (hiking_editors.is_writter=1) as is_writter,
                (hiking_editors.is_financier=1) as is_financier,
                (hiking_editors.is_medic=1) as is_medic,
                (hiking_members_positions.id_position=1) as is_pos1,
                (hiking_members_positions.id_position=2) as is_pos2,
                (hiking_members_positions.id_position=3) as is_pos3,
                (hiking_members_positions.id_position=4) as is_pos4,
                (hiking_members_positions.id_position=5) as is_pos5,
                (hiking_members_positions.id_position=6) as is_pos6,
                (hiking_members_positions.id_position=7) as is_pos7,
                (hiking_members_positions.id_position=8) as is_pos8,
                (hiking_members_positions.id_position=9) as is_pos9,
                (hiking_members_positions.id_position=10) as is_pos10,
                (hiking_members_positions.id_position=11) as is_pos11,
                (hiking_members_positions.id_position=12) as is_pos12,
                (hiking_members_positions.id_position=13) as is_pos13,
                (hiking_members.id IS NOT NULL) as is_member
            FROM
                hiking
                LEFT JOIN hiking_editors ON (hiking_editors.id_hiking = hiking.id AND hiking_editors.id_user={$current_user})
                LEFT JOIN hiking_members_positions ON (hiking_members_positions.id_hiking = hiking.id AND hiking_members_positions.id_user={$current_user})
            LEFT JOIN hiking_members ON (hiking_members.id_hiking = hiking.id AND hiking_members.id_user={$current_user})
            WHERE
                  hiking.id={$id_hiking}
            LIMIT 1";

        $q = $mysqli->query($z);
        if(!$q){
            $rules['error'] = $mysqli->error;
            $rules['error_details'] = $z;
            return $rules;
        }

        if($q->num_rows===0){
            $rules['error'] = "Unknown user for hiking";
            $rules['error_details'] = array("user" => $current_user, "hiking"=>$id_hiking);
            return $rules;
        }

        if($q->num_rows===1){
            $r = $q->fetch_assoc();

            $rules["full"] =        boolByFlags($r, array('is_author'));
            $rules["all"] =         boolByFlags($r, array('is_author', 'is_pos1', ''));
            $rules["routes"] =      boolByFlags($r, array('is_author', 'is_pos1', 'is_pos2', 'is_guide'));
            $rules["kitchen"] =     boolByFlags($r, array('is_author', 'is_pos1', 'is_pos3', 'is_cook'));
            $rules["health"] =      boolByFlags($r, array('is_author', 'is_pos1', 'is_pos4', 'is_medic'));
            $rules["media"] =       boolByFlags($r, array('is_author', 'is_pos1', 'is_pos5'));
            $rules["time"] =        boolByFlags($r, array('is_author', 'is_pos1', 'is_pos6'));
            $rules["equip"] =       boolByFlags($r, array('is_author', 'is_pos1', 'is_pos7', 'is_pos11'));
            $rules["money"] =       boolByFlags($r, array('is_author', 'is_pos1', 'is_pos8', 'is_financier'));
            $rules["info"] =        boolByFlags($r, array('is_author', 'is_pos1', 'is_pos9', 'is_writter'));
            $rules["workouts"] =    boolByFlags($r, array('is_author', 'is_pos1', 'is_pos10'));
            $rules["member"] =      boolByFlags($r, array('is_author', 'is_pos1', 'is_member'));
            $rules["boss"] =        boolByFlags($r, array( 'is_pos1'));
            if (isset($_GET['debug'])) {
                $rules["raw"] =      $r;
            }

            return $rules;
        }

        $rules['empty'] = true;
        return $rules;
    }


    function hasHikingRules($id_hiking, $rules = array('full', 'all')) {
        $rules_map = getRulesForHiking($id_hiking);

        foreach (array('full', 'all') as $k) {
            if ($rules_map[$k]) {
                return true;
            }
        }
        foreach ($rules as $k) {
            if ($rules_map[$k]) {
                return true;
            }
        }
        return false;
    }
