CREATE TYPE role_enum AS ENUM ('jobseeker', 'company');
CREATE TYPE lokasi_enum AS ENUM ('on-site', 'hybrid', 'remote');
CREATE TYPE status_enum AS ENUM ('accepted', 'rejected', 'waiting');

CREATE TABLE IF NOT EXISTS users (
    user_id SERIAL PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    role role_enum
);

CREATE TABLE IF NOT EXISTS company_detail (
    company_id SERIAL PRIMARY KEY,
    user_id INT REFERENCES users(user_id) ON DELETE CASCADE,
    lokasi VARCHAR(255),
    about TEXT
);

CREATE TABLE IF NOT EXISTS lowongan (
    lowongan_id SERIAL PRIMARY KEY,
    company_id INT REFERENCES company_detail(company_id) ON DELETE CASCADE,
    posisi VARCHAR(255),
    deskripsi TEXT,
    jenis_pekerjaan VARCHAR(255),
    jenis_lokasi lokasi_enum,
    is_open BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS attachment_lowongan (
    attachment_id SERIAL PRIMARY KEY,
    lowongan_id INT REFERENCES lowongan(lowongan_id) ON DELETE CASCADE,
    file_path TEXT
);

CREATE TABLE IF NOT EXISTS lamaran (
    lamaran_id SERIAL PRIMARY KEY,
    user_id INT REFERENCES users(user_id) ON DELETE CASCADE,
    lowongan_id INT REFERENCES lowongan(lowongan_id) ON DELETE CASCADE,
    cv_path TEXT,
    video_path TEXT,
    status status_enum,
    status_reason TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE OR REPLACE FUNCTION update_timestamp()
RETURNS TRIGGER AS $$
BEGIN
   IF ROW(NEW.*) IS DISTINCT FROM ROW(OLD.*) THEN
       NEW.updated_at = CURRENT_TIMESTAMP;
   END IF;
   RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER update_timestamp_trigger
BEFORE UPDATE ON lowongan
FOR EACH ROW
WHEN (OLD.posisi IS DISTINCT FROM NEW.posisi
      OR OLD.deskripsi IS DISTINCT FROM NEW.deskripsi
      OR OLD.jenis_pekerjaan IS DISTINCT FROM NEW.jenis_pekerjaan
      OR OLD.jenis_lokasi IS DISTINCT FROM NEW.jenis_lokasi
      OR OLD.is_open IS DISTINCT FROM NEW.is_open)
EXECUTE FUNCTION update_timestamp();
