CREATE TYPE role_enum AS ENUM ('jobseeker', 'company');
CREATE TYPE location_enum AS ENUM ('on-site', 'hybrid', 'remote');
CREATE TYPE status_enum AS ENUM ('accepted', 'rejected', 'waiting');
CREATE TYPE job_type_enum AS ENUM('Full-time', 'Part-time', 'Internship');

CREATE TABLE IF NOT EXISTS users (
    user_id SERIAL PRIMARY KEY,
    nama VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    role role_enum NOT NULL
);

CREATE TABLE IF NOT EXISTS company_detail (
    company_id SERIAL PRIMARY KEY REFERENCES users(user_id) ON DELETE CASCADE ON UPDATE CASCADE,
    company_name VARCHAR(255),
    lokasi VARCHAR(255) NOT NULL,
    about TEXT NOT NULL
);

CREATE TABLE IF NOT EXISTS lowongan(
    lowongan_id SERIAL PRIMARY KEY,
    company_id INT REFERENCES company_detail(company_id) ON DELETE CASCADE ON UPDATE CASCADE,
    posisi VARCHAR(255) NOT NULL,
    deskripsi TEXT NOT NULL,
    jenis_pekerjaan job_type_enum NOT NULL,
    jenis_lokasi location_enum NOT NULL,
    is_open BOOLEAN DEFAULT TRUE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL
);

CREATE TABLE IF NOT EXISTS attachment_lowongan (
    attachment_id SERIAL PRIMARY KEY,
    lowongan_id INT REFERENCES lowongan(lowongan_id) ON DELETE CASCADE,
    file_path TEXT NOT NULL
);

CREATE TABLE IF NOT EXISTS lamaran (
    lamaran_id SERIAL PRIMARY KEY,
    user_id INT REFERENCES users(user_id) ON DELETE CASCADE,
    lowongan_id INT REFERENCES lowongan(lowongan_id) ON DELETE CASCADE,
    cv_path TEXT NOT NULL,
    video_path TEXT,
    status status_enum NOT NULL, 
    status_reason TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    update_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL
);

-- timestamp
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


-- Memastikan jika nama di users diganti, company_name di company_detail juga terganti
CREATE OR REPLACE FUNCTION update_company_name()
RETURNS TRIGGER AS $$
BEGIN
    IF (OLD.nama IS DISTINCT FROM NEW.nama) THEN
        UPDATE company_detail
        SET company_name = NEW.nama
        WHERE company_id = NEW.user_id; 
    END IF;
    RETURN NEW;  
END;
$$ LANGUAGE plpgsql;


CREATE TRIGGER update_company_name_trigger
AFTER UPDATE OF nama ON users
FOR EACH ROW
EXECUTE FUNCTION update_company_name();

-- Seeding data

-- Clear existing data (if any)
TRUNCATE TABLE lamaran, attachment_lowongan, lowongan, company_detail, users CASCADE;

-- Reset sequences
ALTER SEQUENCE users_user_id_seq RESTART WITH 1;
ALTER SEQUENCE company_detail_company_id_seq RESTART WITH 1;
ALTER SEQUENCE lowongan_lowongan_id_seq RESTART WITH 1;
ALTER SEQUENCE attachment_lowongan_attachment_id_seq RESTART WITH 1;
ALTER SEQUENCE lamaran_lamaran_id_seq RESTART WITH 1;

-- Insert Users
INSERT INTO users (nama, password, email, role) VALUES
-- Job Seekers
('John Doe', 'hashed_password123', 'john@example.com', 'jobseeker'),
('Jane Smith', 'hashed_password456', 'jane@example.com', 'jobseeker'),
('Michael Brown', 'hashed_password789', 'michael@example.com', 'jobseeker'),
('Sarah Wilson', 'hashed_password101', 'sarah@example.com', 'jobseeker'),
('Robert Johnson', 'hashed_password102', 'robert@example.com', 'jobseeker'),
('Emily Davis', 'hashed_password103', 'emily@example.com', 'jobseeker'),
('David Miller', 'hashed_password104', 'david@example.com', 'jobseeker'),
('Lisa Anderson', 'hashed_password105', 'lisa@example.com', 'jobseeker'),
('James Wilson', 'hashed_password106', 'james@example.com', 'jobseeker'),
('Maria Garcia', 'hashed_password107', 'maria@example.com', 'jobseeker'),
-- Companies
('Google Inc.', 'company_password123', 'careers@google.com', 'company'),
('Microsoft', 'company_password456', 'careers@microsoft.com', 'company'),
('Amazon', 'company_password789', 'careers@amazon.com', 'company'),
('Meta', 'company_password101', 'careers@meta.com', 'company'),
('Netflix', 'company_password102', 'careers@netflix.com', 'company'),
('Apple', 'company_password103', 'careers@apple.com', 'company'),
('Twitter', 'company_password104', 'careers@twitter.com', 'company'),
('LinkedIn', 'company_password105', 'careers@linkedin.com', 'company'),
('Spotify', 'company_password106', 'careers@spotify.com', 'company'),
('Adobe', 'company_password107', 'careers@adobe.com', 'company');

-- Insert Company Details
INSERT INTO company_detail (company_id, company_name, lokasi, about) VALUES
(11, 'Google Inc.', 'Mountain View, CA', 'Google is a multinational technology company specializing in Internet-related services and products.'),
(12, 'Microsoft', 'Redmond, WA', 'Microsoft is a multinational technology corporation producing computer software, consumer electronics, and personal computers.'),
(13, 'Amazon', 'Seattle, WA', 'Amazon is a multinational technology company focusing on e-commerce, cloud computing, digital streaming, and artificial intelligence.'),
(14, 'Meta', 'Menlo Park, CA', 'Meta is building the future of social connection and virtual reality technologies.'),
(15, 'Netflix', 'Los Gatos, CA', 'Netflix is a streaming service offering a wide variety of award-winning content and original productions.'),
(16, 'Apple', 'Cupertino, CA', 'Apple designs and develops consumer electronics, software, and services.'),
(17, 'Twitter', 'San Francisco, CA', 'Twitter is a social networking platform for public self-expression and conversation.'),
(18, 'LinkedIn', 'Sunnyvale, CA', 'LinkedIn is the world''s largest professional network platform.'),
(19, 'Spotify', 'Stockholm, Sweden', 'Spotify is a digital music, podcast, and video streaming service.'),
(20, 'Adobe', 'San Jose, CA', 'Adobe is a global leader in digital media and digital marketing solutions.');

-- Insert Job Listings (Lowongan)
INSERT INTO lowongan (company_id, posisi, deskripsi, jenis_pekerjaan, jenis_lokasi, is_open) VALUES
-- Google Positions
(11, 'Senior Software Engineer', 'Leading development of next-generation search algorithms.', 'full-time', 'hybrid', true),
(11, 'Product Manager', 'Lead product strategy for Google Cloud initiatives.', 'full-time', 'on-site', true),
(11, 'Machine Learning Engineer', 'Develop ML models for Google Assistant.', 'full-time', 'remote', true),

-- Microsoft Positions
(12, 'Frontend Developer', 'Build responsive web applications using React.', 'full-time', 'remote', true),
(12, 'DevOps Engineer', 'Manage Azure cloud infrastructure.', 'full-time', 'hybrid', true),
(12, 'Game Developer', 'Create next-gen gaming experiences for Xbox.', 'full-time', 'on-site', true),

-- Amazon Positions
(13, 'Data Scientist', 'Analyze customer behavior patterns.', 'Full-time', 'on-site', true),
(13, 'Solutions Architect', 'Design AWS cloud solutions.', 'Full-time', 'remote', true),
(13, 'UX Designer', 'Design shopping experiences.', 'Internship', 'remote', false),

-- Meta Positions
(14, 'AR/VR Developer', 'Build immersive experiences for Meta Quest.', 'full-time', 'hybrid', true),
(14, 'Privacy Engineer', 'Implement data protection measures.', 'full-time', 'on-site', true),
(14, 'Content Moderator', 'Review and moderate content.', 'part-time', 'remote', true),

-- Netflix Positions
(15, 'Content Algorithm Engineer', 'Improve content recommendation systems.', 'Full-time', 'hybrid', true),
(15, 'Platform Engineer', 'Maintain streaming infrastructure.', 'Full-time', 'on-site', true),
(15, 'Quality Assurance Engineer', 'Ensure streaming quality across devices.', 'Internship', 'remote', true),

-- Apple Positions
(16, 'iOS Developer', 'Develop new features for iOS.', 'full-time', 'on-site', true),
(16, 'Hardware Engineer', 'Design next-gen Apple devices.', 'full-time', 'on-site', true),
(16, 'Machine Learning Researcher', 'Advance Siri capabilities.', 'full-time', 'hybrid', true),

-- Twitter Positions
(17, 'Backend Engineer', 'Scale Twitter''s distributed systems.', 'full-time', 'remote', true),
(17, 'Data Engineer', 'Build data pipelines.', 'full-time', 'hybrid', true),
(17, 'Security Engineer', 'Protect user data and privacy.', 'full-time', 'on-site', false),

-- LinkedIn Positions
(18, 'Full Stack Developer', 'Develop features across the stack.', 'full-time', 'hybrid', true),
(18, 'AI Engineer', 'Improve job matching algorithms.', 'full-time', 'remote', true),
(18, 'Technical Product Manager', 'Lead development of new features.', 'full-time', 'on-site', true),

-- Spotify Positions
(19, 'Audio Engineer', 'Optimize streaming quality.', 'Full-time', 'on-site', true),
(19, 'Recommendation Engineer', 'Improve music recommendations.', 'Full-time', 'remote', true),
(19, 'Product Designer', 'Design new user experiences.', 'Internship', 'hybrid', true),

-- Adobe Positions
(20, 'Graphics Engineer', 'Develop new creative tools.', 'full-time', 'on-site', true),
(20, 'Cloud Engineer', 'Maintain Creative Cloud services.', 'full-time', 'remote', true),
(20, 'Technical Support Engineer', 'Support enterprise customers.', 'part-time', 'hybrid', false);

-- Insert Attachments for Job Listings
INSERT INTO attachment_lowongan (lowongan_id, file_path) VALUES
(1, '/public/attachment_1.png'),
(1, '/public/attachment_2.png'),
(1, '/public/attachment_3.png'),
(2, '/public/attachment_4.png'),
(3, '/public/attachment_5.png'),
(4, '/public/attachment_6.png'),
(4, '/public/attachment_7.png'),
(5, '/public/attachment_8.png'),
(6, '/public/attachment_9.png'),
(7, '/public/attachment_10.png'),
(10, '/public/attachment_11.png'),
(13, '/public/attachment_12.png'),
(16, '/public/attachment_13.png'),
(19, '/public/attachment_14.png'),
(22, '/public/attachment_15.png'),
(25, '/public/attachment_16.png'),
(28, '/public/attachment_17.png');


-- Insert Job Applications (Lamaran)
INSERT INTO lamaran (user_id, lowongan_id, cv_path, video_path, status, status_reason) VALUES
-- John Doe's Applications
(1, 1, '/cv/john_doe_cv.pdf', '/video/john_doe_intro.mp4', 'waiting', NULL),
(1, 4, '/cv/john_doe_cv.pdf', '/video/john_doe_frontend.mp4', 'accepted', 'Excellent technical assessment results'),
(1, 19, '/cv/john_doe_cv.pdf', NULL, 'rejected', 'Limited distributed systems experience'),

-- Jane Smith's Applications
(2, 2, '/cv/jane_smith_cv.pdf', '/video/jane_smith_pm.mp4', 'accepted', 'Strong product vision and leadership skills'),
(2, 22, '/cv/jane_smith_cv.pdf', NULL, 'waiting', NULL),
(2, 13, '/cv/jane_smith_cv.pdf', '/video/jane_smith_algo.mp4', 'rejected', 'More ML experience required'),

-- Michael Brown's Applications
(3, 3, '/cv/michael_brown_cv.pdf', '/video/michael_brown_ml.mp4', 'accepted', 'Impressive ML portfolio'),
(3, 7, '/cv/michael_brown_cv.pdf', NULL, 'waiting', NULL),
(3, 25, '/cv/michael_brown_cv.pdf', '/video/michael_brown_audio.mp4', 'rejected', 'Looking for more audio engineering background'),

-- Sarah Wilson's Applications
(4, 10, '/cv/sarah_wilson_cv.pdf', '/video/sarah_wilson_vr.mp4', 'accepted', 'Excellent VR development portfolio'),
(4, 16, '/cv/sarah_wilson_cv.pdf', NULL, 'waiting', NULL),

-- Robert Johnson's Applications
(5, 5, '/cv/robert_johnson_cv.pdf', '/video/robert_devops.mp4', 'accepted', 'Strong Azure certification and experience'),
(5, 8, '/cv/robert_johnson_cv.pdf', NULL, 'rejected', 'Position filled internally'),

-- Emily Davis's Applications
(6, 28, '/cv/emily_davis_cv.pdf', '/video/emily_graphics.mp4', 'waiting', NULL),
(6, 6, '/cv/emily_davis_cv.pdf', NULL, 'rejected', 'More gaming industry experience needed'),

-- David Miller's Applications
(7, 14, '/cv/david_miller_cv.pdf', '/video/david_platform.mp4', 'accepted', 'Strong system design skills'),
(7, 20, '/cv/david_miller_cv.pdf', NULL, 'waiting', NULL),

-- Lisa Anderson's Applications
(8, 11, '/cv/lisa_anderson_cv.pdf', '/video/lisa_privacy.mp4', 'accepted', 'Excellent privacy framework knowledge'),
(8, 17, '/cv/lisa_anderson_cv.pdf', NULL, 'rejected', 'Position no longer available'),

-- James Wilson's Applications
(9, 23, '/cv/james_wilson_cv.pdf', '/video/james_ai.mp4', 'waiting', NULL),
(9, 26, '/cv/james_wilson_cv.pdf', NULL, 'accepted', 'Strong algorithmic background'),

-- Maria Garcia's Applications
(10, 29, '/cv/maria_garcia_cv.pdf', '/video/maria_support.mp4', 'rejected', 'Looking for more enterprise support experience'),
(10, 15, '/cv/maria_garcia_cv.pdf', NULL, 'waiting', NULL);