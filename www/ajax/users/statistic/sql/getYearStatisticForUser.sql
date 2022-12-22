SELECT
  SUM(workout_tracks.distance) as distance,
  SUM(workout_tracks.alt_ascent) as alt_ascent,
  SUM(workout_tracks.alt_descent) as alt_descent,
  MAX(workout_tracks.alt_max) as alt_max,
  MIN(workout_tracks.alt_min) as alt_min,
  SUM(workout_tracks.date_finish - workout_tracks.date_start) as hv,
  hiking_types.name as type_name,
  hiking.name,
  hiking.ava,
  hiking.id,
  GROUP_CONCAT(DISTINCT CONCAT_WS('→', hiking_tracks.name, workout_tracks.trackdata) SEPARATOR '\n') as tracks,
  IF(NOT(ISNULL(hiking_members.date_from)), hiking_members.date_from, hiking.start) as date_start,
  IF(NOT(ISNULL(hiking_members.date_to)), hiking_members.date_to, hiking.finish) as date_finish,
  (
    SELECT
      GROUP_CONCAT(DISTINCT CONCAT_WS(
        '→',
        users.id,
        users.name,
        users.surname,
        users.photo_50,
        IF(NOT(ISNULL(hiking_members.date_from)), hiking_members.date_from, hiking.start),
        IF(NOT(ISNULL(hiking_members.date_to)), hiking_members.date_to, hiking.finish)
      ) SEPARATOR '\n')
    FROM hiking_members
      LEFT JOIN users ON users.id = hiking_members.id_user
    WHERE hiking_members.id_hiking=hiking.id
  ) as friends,
  (
    SELECT
      GROUP_CONCAT(CONCAT_WS('→',hiking_members_positions.id_user, positions.name) SEPARATOR '\n')
    FROM hiking_members_positions
      LEFT JOIN positions ON positions.id = hiking_members_positions.id_position
    WHERE hiking_members_positions.id_hiking=hiking.id
  ) as poss
FROM hiking_members
  LEFT JOIN hiking ON hiking_members.id_hiking = hiking.id
  LEFT JOIN hiking_types ON hiking_types.id = hiking.id_type
  LEFT JOIN hiking_tracks ON hiking_tracks.id_hiking = hiking.id
  LEFT JOIN workout_tracks ON (
    hiking_tracks.id_workout_track = workout_tracks.id AND (
      workout_tracks.date_start BETWEEN IF(NOT(ISNULL(hiking_members.date_from)), hiking_members.date_from, hiking.start)
      AND IF(NOT(ISNULL(hiking_members.date_to)), hiking_members.date_to, hiking.finish)
    )AND (
      workout_tracks.date_finish BETWEEN IF(NOT(ISNULL(hiking_members.date_from)), hiking_members.date_from, hiking.start)
      AND IF(NOT(ISNULL(hiking_members.date_to)), hiking_members.date_to, hiking.finish)
    )
  ) 
WHERE
  hiking_members.id_user = @id_user
  AND YEAR(hiking.start) = @year
GROUP By hiking.id;