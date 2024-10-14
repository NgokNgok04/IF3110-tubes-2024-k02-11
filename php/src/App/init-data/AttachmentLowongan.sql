CREATE TABLE AttachmentLowongan (
    attachment_id SERIAL PRIMARY KEY,
    lowongan_id INT REFERENCES Lowongan(lowongan_id),
    file_path TEXT
);