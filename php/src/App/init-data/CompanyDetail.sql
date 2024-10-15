CREATE TABLE CompanyDetail (
    company_id INT PRIMARY KEY,
    company_name TEXT, 
    user_id INT REFERENCES users(user_id),
    lokasi VARCHAR(255),
    about TEXT
);

