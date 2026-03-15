SELECT
  workout_targets.`id`,
  workout_targets.`id_hiking`,
  workout_targets.`id_author`,
  workout_targets.`is_public`,
  workout_targets.`date_create`,
  workout_targets.`date_update`,
  workout_targets.`name`,
  workout_targets.`workout_type`,
  workout_targets.`description`,
  workout_targets.`date_start`,
  workout_targets.`date_finish`,
  workout_targets.`distance`,
  workout_targets.`alt_ascent`,
  workout_targets.`alt_descent`,
  workout_targets.`speed_max`,
  workout_targets.`speed_min`,
  workout_targets.`speed_avg`,
  workout_targets.`hr_max`,
  workout_targets.`hr_min`,
  workout_targets.`hr_avg`,
  workout_targets.`time_mooving`,
  workout_types.name AS workout_type_name,
  author.id AS author_id,
  author.name AS author_name,
  author.surname AS author_surname,
  author.photo_50 AS author_photo,
  workout_targets.id_hiking AS hiking_id,
  hiking.name AS hiking_name,
  hiking.ava AS hiking_ava,
  hiking.start AS hiking_start,
  hiking.finish AS hiking_finish
FROM
  `workout_targets`
  LEFT JOIN workout_types ON workout_targets.workout_type = workout_types.id
  LEFT JOIN users AS author ON author.id = workout_targets.`id_author`
  LEFT JOIN hiking ON workout_targets.id_hiking = hiking.id
WHERE
  1
  --@need_filter_by_id AND workout_targets.id=@id
  --@need_filter_by_hiking AND workout_targets.id_hiking=@id_hiking
  --@need_filter_by_type AND workout_targets.workout_type=@id_type
  --@actual AND DATE(workout_targets.date_finish) > DATE(NOW())
  --@my AND (workout_targets.id_author=@id_user
  --@my   OR @id_user IN(SELECT id_user FROM workout_target_members WHERE workout_target_members.id_workout_target = workout_targets.id)
  --@my   OR @id_user IN(SELECT id_user FROM hiking_members WHERE hiking_members.id_hiking = workout_targets.id_hiking)
  --@my )

  ORDER  BY  workout_targets.`date_finish` DESC
