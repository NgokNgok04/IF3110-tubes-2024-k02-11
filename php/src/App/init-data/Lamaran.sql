CREATE TYPE status_enum AS ENUM ('Pending', 'Accepted', 'Rejected');

CREATE TABLE Lamaran (
    lamaran_id SERIAL PRIMARY KEY,
    user_id INT REFERENCES users(user_id),
    lowongan_id INT REFERENCES Lowongan(lowongan_id),
    cv_path TEXT, 
    video_path TEXT, 
    status status_enum, 
    status_reason TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);