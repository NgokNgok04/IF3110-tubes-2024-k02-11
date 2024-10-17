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
(11, 'Senior Software Engineer', 'Leading development of next-generation search algorithms.', 'Full-time', 'hybrid', true),
(11, 'Product Manager', 'Lead product strategy for Google Cloud initiatives.', 'Full-time', 'on-site', true),
(11, 'Machine Learning Engineer', 'Develop ML models for Google Assistant.', 'Full-time', 'remote', true),

-- Microsoft Positions
(12, 'Frontend Developer', 'Build responsive web applications using React.', 'Full-time', 'remote', true),
(12, 'DevOps Engineer', 'Manage Azure cloud infrastructure.', 'Full-time', 'hybrid', true),
(12, 'Game Developer', 'Create next-gen gaming experiences for Xbox.', 'Full-time', 'on-site', true),

-- Amazon Positions
(13, 'Data Scientist', 'Analyze customer behavior patterns.', 'Full-time', 'on-site', true),
(13, 'Solutions Architect', 'Design AWS cloud solutions.', 'Full-time', 'remote', true),
(13, 'UX Designer', 'Design shopping experiences.', 'Contract', 'remote', false),

-- Meta Positions
(14, 'AR/VR Developer', 'Build immersive experiences for Meta Quest.', 'Full-time', 'hybrid', true),
(14, 'Privacy Engineer', 'Implement data protection measures.', 'Full-time', 'on-site', true),
(14, 'Content Moderator', 'Review and moderate content.', 'Part-time', 'remote', true),

-- Netflix Positions
(15, 'Content Algorithm Engineer', 'Improve content recommendation systems.', 'Full-time', 'hybrid', true),
(15, 'Platform Engineer', 'Maintain streaming infrastructure.', 'Full-time', 'on-site', true),
(15, 'Quality Assurance Engineer', 'Ensure streaming quality across devices.', 'Contract', 'remote', true),

-- Apple Positions
(16, 'iOS Developer', 'Develop new features for iOS.', 'Full-time', 'on-site', true),
(16, 'Hardware Engineer', 'Design next-gen Apple devices.', 'Full-time', 'on-site', true),
(16, 'Machine Learning Researcher', 'Advance Siri capabilities.', 'Full-time', 'hybrid', true),

-- Twitter Positions
(17, 'Backend Engineer', 'Scale Twitter''s distributed systems.', 'Full-time', 'remote', true),
(17, 'Data Engineer', 'Build data pipelines.', 'Full-time', 'hybrid', true),
(17, 'Security Engineer', 'Protect user data and privacy.', 'Full-time', 'on-site', false),

-- LinkedIn Positions
(18, 'Full Stack Developer', 'Develop features across the stack.', 'Full-time', 'hybrid', true),
(18, 'AI Engineer', 'Improve job matching algorithms.', 'Full-time', 'remote', true),
(18, 'Technical Product Manager', 'Lead development of new features.', 'Full-time', 'on-site', true),

-- Spotify Positions
(19, 'Audio Engineer', 'Optimize streaming quality.', 'Full-time', 'on-site', true),
(19, 'Recommendation Engineer', 'Improve music recommendations.', 'Full-time', 'remote', true),
(19, 'Product Designer', 'Design new user experiences.', 'Contract', 'hybrid', true),

-- Adobe Positions
(20, 'Graphics Engineer', 'Develop new creative tools.', 'Full-time', 'on-site', true),
(20, 'Cloud Engineer', 'Maintain Creative Cloud services.', 'Full-time', 'remote', true),
(20, 'Technical Support Engineer', 'Support enterprise customers.', 'Part-time', 'hybrid', false);

-- Insert Attachments for Job Listings
INSERT INTO attachment_lowongan (lowongan_id, file_path) VALUES
-- Google Attachments
(1, '/attachments/google/swe_jd.pdf'),
(1, '/attachments/google/swe_requirements.pdf'),
(1, '/attachments/google/benefits.pdf'),
(2, '/attachments/google/pm_jd.pdf'),
(3, '/attachments/google/ml_requirements.pdf'),

-- Microsoft Attachments
(4, '/attachments/microsoft/frontend_jd.pdf'),
(4, '/attachments/microsoft/frontend_assessment.pdf'),
(5, '/attachments/microsoft/devops_jd.pdf'),
(6, '/attachments/microsoft/game_dev_requirements.pdf'),

-- Various Company Attachments
(7, '/attachments/amazon/ds_jd.pdf'),
(10, '/attachments/meta/arvr_requirements.pdf'),
(13, '/attachments/netflix/algorithm_test.pdf'),
(16, '/attachments/apple/ios_technical_test.pdf'),
(19, '/attachments/twitter/backend_assessment.pdf'),
(22, '/attachments/linkedin/fullstack_challenge.pdf'),
(25, '/attachments/spotify/audio_engineering_specs.pdf'),
(28, '/attachments/adobe/graphics_portfolio_requirements.pdf');

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