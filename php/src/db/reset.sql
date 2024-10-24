DROP TABLE IF EXISTS lowongan CASCADE;
DROP TABLE IF EXISTS companydetail CASCADE;
DROP TABLE IF EXISTS users CASCADE;
DROP TABLE IF EXISTS attachment_lowongan CASCADE;
DROP TABLE IF EXISTS lamaran CASCADE;
DROP TYPE role_enum;
DROP TYPE location_enum;
DROP TYPE status_enum;
DROP TYPE job_type_enum;

DROP FUNCTION IF EXISTS update_timestamp() CASCADE;
DROP TRIGGER IF EXISTS update_timestamp_trigger ON lowongan CASCADE;
