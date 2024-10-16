from faker import Faker;
import requests;
import hashlib;
import random

fake = Faker()
role = ["jobseeker","company"]
def generate_fake_account():
    hash_object = hashlib.sha256()
    password = "password"
    hash_object.update(password.encode('utf-8'))
    
    return {
        "nama": fake.name(),
        "password": hash_object.hexdigest(),
        "email": fake.email(), 
        "role": role[random.randint(0,1)]
    }
api_url = 'http://localhost:8000/register'

for i in range(10):
    data = generate_fake_account()

    form_data = {
        "name": data['nama'],
        "email": data['email'],
        "password": "password",  # Send plain password, as PHP will hash it
        "role": data['role'],
        "submit": "register"
    }

    try:
        # Send the data as form-encoded, not JSON
        response = requests.post(api_url, data=form_data)
        if response.status_code == 201:
            print("Data seeded successfully:", form_data)
        else:
            print("Failed to seed data:", response.status_code, response.text)
    except requests.RequestException as e:
        print("Request failed:", e)


# INSERT INTO users (nama, password, email, role) VALUES
# ('John Doe', '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd6a7c4cf94fcce9d3e', 'john.doe@example.com', 'jobseeker'),
# ('Jane Smith', '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd6a7c4cf94fcce9d3e', 'jane.smith@company.com', 'company'),
# ('Alice Johnson', '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd6a7c4cf94fcce9d3e', 'alice.j@example.com', 'jobseeker'),
# ('Bob Brown', '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd6a7c4cf94fcce9d3e', 'bob.brown@company.com', 'company'),
# ('Charlie Evans', '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd6a7c4cf94fcce9d3e', 'charlie.evans@example.com', 'jobseeker'),
# ('Diana Miller', '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd6a7c4cf94fcce9d3e', 'diana.miller@company.com', 'company'),
# ('Evan Rogers', '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd6a7c4cf94fcce9d3e', 'evan.rogers@example.com', 'jobseeker'),
# ('Fiona Green', '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd6a7c4cf94fcce9d3e', 'fiona.green@company.com', 'company'),
# ('George Harris', '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd6a7c4cf94fcce9d3e', 'george.harris@example.com', 'jobseeker'),
# ('Hannah Adams', '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd6a7c4cf94fcce9d3e', 'hannah.adams@company.com', 'company');

# INSERT INTO company_detail (company_name, user_id, lokasi, about) VALUES
# ('Tech Innovators Inc.', 2, 'remote', 'Leading tech innovation.'),
# ('Global Enterprises', 4, 'on-site', 'Providing global solutions.'),
# ('Creative Labs', 6, 'hybrid', 'Creative technology and services.'),
# ('NextGen Solutions', 8, 'remote', 'Next generation software solutions.'),
# ('Future Works', 10, 'hybrid', 'Innovative tech company.'),
# ('Eco Systems', 4, 'on-site', 'Sustainable energy solutions.'),
# ('Digital Dynamics', 6, 'remote', 'Leading the digital revolution.'),
# ('Skyline Technologies', 8, 'hybrid', 'Building the future of tech.'),
# ('Pioneer Corp', 2, 'remote', 'Innovating for a better future.'),
# ('Quantum Enterprises', 10, 'on-site', 'Quantum computing and research.');

# INSERT INTO lowongan (company_id, posisi, deskripsi, jenis_pekerjaan, jenis_lokasi) VALUES
# (1, 'Software Engineer', 'Develop and maintain software applications.', 'full-time', 'remote'),
# (2, 'Data Analyst', 'Analyze data trends and insights.', 'part-time', 'on-site'),
# (3, 'Project Manager', 'Lead and manage projects.', 'contract', 'hybrid'),
# (4, 'Product Designer', 'Design innovative products.', 'full-time', 'remote'),
# (5, 'System Administrator', 'Manage IT systems and networks.', 'full-time', 'hybrid'),
# (6, 'Sales Manager', 'Manage sales team and operations.', 'full-time', 'on-site'),
# (7, 'Marketing Specialist', 'Develop marketing strategies.', 'part-time', 'remote'),
# (8, 'HR Specialist', 'Handle recruitment and employee relations.', 'contract', 'hybrid'),
# (9, 'Business Analyst', 'Analyze business processes and suggest improvements.', 'full-time', 'on-site'),
# (10, 'DevOps Engineer', 'Ensure smooth software deployment.', 'full-time', 'remote');

# INSERT INTO attachment_lowongan (lowongan_id, file_path) VALUES
# (1, '/files/attachments/lowongan_1_description.pdf'),
# (2, '/files/attachments/lowongan_2_specifications.pdf'),
# (3, '/files/attachments/lowongan_3_description.pdf'),
# (4, '/files/attachments/lowongan_4_specifications.pdf'),
# (5, '/files/attachments/lowongan_5_description.pdf'),
# (6, '/files/attachments/lowongan_6_specifications.pdf'),
# (7, '/files/attachments/lowongan_7_description.pdf'),
# (8, '/files/attachments/lowongan_8_specifications.pdf'),
# (9, '/files/attachments/lowongan_9_description.pdf'),
# (10, '/files/attachments/lowongan_10_specifications.pdf');

# INSERT INTO lamaran (user_id, lowongan_id, cv_path, video_path, status, status_reason) VALUES
# (1, 1, '/files/cvs/johndoe_cv.pdf', '/files/videos/johndoe_intro.mp4', 'waiting', NULL),
# (3, 2, '/files/cvs/alicejohnson_cv.pdf', NULL, 'accepted', 'Candidate has strong data skills.'),
# (5, 3, '/files/cvs/charlieevans_cv.pdf', '/files/videos/charlieevans_intro.mp4', 'waiting', NULL),
# (7, 4, '/files/cvs/evanrogers_cv.pdf', NULL, 'rejected', 'Position already filled.'),
# (9, 5, '/files/cvs/georgeharris_cv.pdf', '/files/videos/georgeharris_intro.mp4', 'accepted', 'Impressive qualifications.'),
# (1, 6, '/files/cvs/johndoe_cv.pdf', NULL, 'waiting', NULL),
# (3, 7, '/files/cvs/alicejohnson_cv.pdf', '/files/videos/alicejohnson_intro.mp4', 'rejected', 'Not enough experience.'),
# (5, 8, '/files/cvs/charlieevans_cv.pdf', NULL, 'accepted', 'Excellent portfolio.'),
# (7, 9, '/files/cvs/evanrogers_cv.pdf', '/files/videos/evanrogers_intro.mp4', 'waiting', NULL),
# (9, 10, '/files/cvs/georgeharris_cv.pdf', NULL, 'accepted', 'Outstanding skills and background.');