SELECT
  users.id,
  users.name,
  users.surname,
  users.photo_50,
  GROUP_CONCAT(
    DISTINCT CONCAT_WS(
      'œ',
      workouts.id,
      workouts.name,
      workout_tracks.date_start,
      workout_tracks.date_finish,
      workout_tracks.distance,
      workout_types.id,
      workout_types.name
    ) SEPARATOR 'æ'
  ) AS workouts_raw,
  MIN(`workout_tracks`.`date_start`) AS first_workout_date,
  MAX(`workout_tracks`.`date_finish`) AS max_workout_date,
  SUM(`workout_tracks`.`distance`) AS distance,
  SUM(`workout_tracks`.`alt_ascent`) AS alt_ascent,
  SUM(`workout_tracks`.`alt_descent`) AS alt_descent,
  MAX(`workout_tracks`.`alt_max`) AS alt_max,
  MIN(`workout_tracks`.`alt_min`) AS alt_min,
  AVG(`workout_tracks`.`alt_avg`) AS alt_avg,
  MAX(`workout_tracks`.`speed_max`) AS speed_max,
  MIN(`workout_tracks`.`speed_min`) AS speed_min,
  AVG(`workout_tracks`.`speed_avg`) AS speed_avg,
  MAX(`workout_tracks`.`hr_max`) AS hr_max,
  MIN(`workout_tracks`.`hr_min`) AS hr_min,
  AVG(`workout_tracks`.`hr_avg`) AS hr_avg,
  SUM(`workout_tracks`.`time_mooving`) AS time_mooving
FROM
  workouts 
  LEFT JOIN users ON workouts.id_user = users.id
  LEFT JOIN workout_tracks ON workouts.id_workout_track = workout_tracks.id
  LEFT JOIN workout_types ON workouts.workout_type = workout_types.id
  LEFT JOIN workout_targets ON workout_targets.id = @id_workout_target
WHERE
  workouts.id_user IN(@user_ids)
  AND (workout_types.id = workout_targets.workout_type OR workout_targets.workout_type IS NULL)
  AND workout_tracks.date_start BETWEEN workout_targets.date_start AND workout_targets.date_finish
GROUP BY
  users.id
ORDER BY
  distance DESC,`workout_tracks`.`date_start` ASC
