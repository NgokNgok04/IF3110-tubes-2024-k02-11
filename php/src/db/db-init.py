
import requests
import random
from faker import Faker
print("""
SEEDING BUAT MILESTONE 1
===============================
      
""")

COMPANY_NAME = [
    ["Oyoyo", "Banakaja", "A local food delivery platform known for authentic cuisine"],
    ["Twitterbeat", "Denpasar", "Social media analytics for influencers in Bali"],
    ["Rooxo", "Jakarta", "E-commerce site with a wide variety of Indonesian-made products"],
    ["Dabshots", "Fatufeto", "Photography services and print-on-demand photo products"],
    ["Skyvu", "Lungmar", "Drone footage provider for breathtaking landscapes"],
    ["Realmix", "Yicheng", "Event management platform for virtual and hybrid events"],
    ["Livefish", "Jampang Tengah", "Fish farming technology startup"],
    ["Zava", "Zheyuan", "Healthy beverage company using local ingredients"],
    ["Oyope", "Gununglajang", "Community-based travel experiences"],
    ["Meedoo", "Glendale", "Health and wellness platform focused on meditation"],
    ["Edgeify", "Medan", "Edge computing solutions for industrial IoT"],
    ["DabZ", "Loga", "Urban streetwear brand for fashion-forward youth"],
    ["Browsebug", "Young America", "Web browsing extension for finding discounts online"],
    ["Livetube", "Tomice", "Livestreaming service for music and art events"],
    ["Yodo", "Tungao", "Pet adoption and animal care platform"],
    ["Photojam", "Chengxi", "Photo-sharing app with social media integration"],
    ["Mita", "Talabaan", "Sustainable skincare brand with natural ingredients"],
    ["Topicblab", "Chipata", "Platform for educational discussions and seminars"],
    ["Aimbu", "Salzburg", "Travel guide app focusing on hidden gems"],
    ["Skiptube", "Rešetari", "Content aggregator for educational videos"],
    ["Edgeclub", "Rulong", "Exclusive network for edge computing professionals"],
    ["Flashdog", "Luena", "Pet sitting and dog walking service"],
    ["Podcat", "Palembang", "Podcast platform for diverse local stories"],
    ["Jabberbean", "Calais", "Language learning through chat with locals"],
    ["Topicware", "Ḩalabjah", "Platform for organizing online conferences"],
    ["Gigabox", "Boise", "Gig economy platform for freelance tech work"],
    ["Livepath", "Huabu", "Real-time event tracking and sharing app"],
    ["Trunyx", "Marseille", "Online marketplace for French artisans"],
    ["Roombo", "Goho", "Short-term rental service for unique stays"],
    ["Voomm", "Pefki", "Carpooling app focused on sustainable travel"],
    ["Eimbee", "Xixi", "Mobile banking solutions for young adults"],
    ["Jayo", "Phon Charoen", "Agricultural technology solutions for small farms"],
    ["Dynabox", "Mabugang", "Cloud storage service with advanced security"],
    ["Meevee", "Kahnuj", "Video streaming service for indie creators"],
    ["Jazzy", "Songjiang", "Online music academy for jazz enthusiasts"],
    ["Riffwire", "Tymbark", "Guitar and music gear marketplace"],
    ["Voonder", "Priargunsk", "Virtual reality content creator platform"],
    ["Mydeo", "Klumpit", "Video-based social media platform for creators"],
    ["Vinder", "Hassleholm", "Dating app with a focus on shared interests"],
    ["Fatz", "Pargas", "Healthy meal delivery service"],
    ["Zoonder", "Dejilin", "Pet social media platform"],
    ["Photobean", "Sanquan", "Photography services and gallery space"],
    ["Devcast", "Jiefang", "Coding bootcamp and developer education platform"],
    ["Flipstorm", "Mosteiros", "Marketplace for used electronics"],
    ["BlogXS", "Rodopoli", "Blogging platform with community features"],
    ["Demivee", "Szydlowo", "Personalized beauty product subscription service"],
    ["Izio", "Abucayan", "Online learning platform for creative skills"],
    ["Cogilith", "Swidwin", "Artificial intelligence research lab"],
    ["Eare", "Quimper", "Audio equipment rental service"],
    ["Kare", "Valle de Angeles", "Nonprofit focusing on community health initiatives"]
]

# $name, $email, $role, $password, $location, $about
# api_url = 'http://localhost:8000/register'
# for company in COMPANY_NAME:
#     data={
#         'name': company[0],
#         'email' : company[0] + '@example',
#         'role' : 'company',
#         'password' : 'password_company',
#         'location' : company[1],
#         'about' : company[2],
#     }
#     response = requests.post(api_url, data=data)
#     if (response.status_code == 200):
#         print(f"company '{data['name']}' inserted successfully.")
#     else:
#         print(f"Failed to insert company '{data['name']}'."),

# id 106-155
# $company_id, $posisi, $deskripsi, $jenis_pekerjaan, $jenis_lokasi, $id

JOB_TYPE = ['Full-time', 'Part-time', 'Internship']
JOB_LOCATION = ['on-site', 'hybrid', 'remote']
api_url = 'http://localhost:8000/tambah-lowongan'
fake = Faker()
company_id = 106
# for company in COMPANY_NAME:
# for i in range (2):
data={
    'id' : company_id,
    'posisi': 'ADAW',
    'deskripsi': 'DAWDWA',
    'jenis_pekerjaan': random.choice(JOB_TYPE),
    'jenis_lokasi' : JOB_LOCATION[random.randint(0,2)],
}
response = requests.post(api_url, data=data)
if (response.status_code == 200):
    print(f"{company_id}. Vacation '{data['posisi']}' inserted successfully.")
else:
    print(f"Failed to insert vacation '{data['posisi']}'."),   
company_id += 1