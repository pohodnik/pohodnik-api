INSERT INTO `workout_track_markup`(`id_workout_track`, `name`, `is_break`, `date_from`, `date_to`, `created_at`, `updated_at`, `id_author`) SELECT 
    hiking_tracks.id_workout_track as `id_workout_track`,
    hiking_tracks_break.name as `name`,
    hiking_tracks_break.is_break as `is_break`,
    FROM_UNIXTIME(hiking_tracks_break.`from_time`) as `date_from`,
    FROM_UNIXTIME(hiking_tracks_break.`to_time`) as `date_to`,
    NOW() as `created_at`,
    NULL  as `updated_at`,
    hiking_tracks_break.id_author as `id_author` 
FROM `hiking_tracks_break` LEFT JOIN hiking_tracks ON hiking_tracks.id = hiking_tracks_break.id_track;

DROP TABLE `hiking_tracks_break`;
