CREATE TYPE lokasi_enum AS ENUM ('Onsite', 'Remote', 'Hybrid');

CREATE TABLE Lowongan (
    lowongan_id SERIAL PRIMARY KEY,
    company_id INT REFERENCES CompanyDetail(company_id),
    posisi VARCHAR(255),
    deskripsi TEXT,
    jenis_pekerjaan VARCHAR(255),
    jenis_lokasi lokasi_enum,
    is_open BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
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
BEFORE UPDATE ON Lowongan
FOR EACH ROW
WHEN (OLD.posisi IS DISTINCT FROM NEW.posisi
      OR OLD.deskripsi IS DISTINCT FROM NEW.deskripsi
      OR OLD.jenis_pekerjaan IS DISTINCT FROM NEW.jenis_pekerjaan
      OR OLD.jenis_lokasi IS DISTINCT FROM NEW.jenis_lokasi
      OR OLD.is_open IS DISTINCT FROM NEW.is_open)
EXECUTE FUNCTION update_timestamp();
