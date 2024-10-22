<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Job</title>
    <link rel="stylesheet" href="../../../public/styles/global.css">
    <link rel="stylesheet" href="../../../public/styles/navbar.css">
    <link rel="stylesheet" href="../../../public/styles/home/homecompany.css">
    <script src="https://kit.fontawesome.com/3816d0d83d.js" crossorigin="anonymous"></script>
</head>
<body>
    <main>
        <section class="main-content">
            <section class="profile-section">
                <div class="profile-bg-blue"></div>
                <div class="profile-bg-white">
                    <div class="profile-image">
                        <img src="../../../public/icons/building.png" class="profile-icon" alt="profile-picture">
                    </div>
                    <h1 class="profile-name"><?php echo isset($companyData['nama']) ? $companyData['nama'] : 'guess'  ?></h1>
                    <h1 class="profile-location"><?php echo isset($companyData['lokasi']) ? $companyData['lokasi'] : 'guess location'?></h1>
                    <h1 class="profile-about"><?php echo isset($companyData['about']) ? $companyData['about'] : 'guess about'  ?></h1>
                </div>
            </section>
            <section class="job-lists">
                <h1 class="job-lists-title">Vacancy List</h1>
                <div class="job-container">
                    <?php foreach ($jobs as $index => $job): ?>
                        <button class="job-card" id="job-card">
                            <h1 class="job-title" id="job-title-<?php echo $index; ?>">
                                <?php echo htmlspecialchars($job['posisi']); ?>
                            </h1>
                            <h1 class="job-company" id="job-company-<?php echo $index; ?>">
                                <?php echo $companyData['nama'] ?>
                            </h1>
                            <h1 class="job-location" id="job-location-<?php echo $index; ?>">
                                <?php echo $companyData['lokasi'] ?>
                            </h1>
                            <h1 class="display-none" id="job-desc-<?php echo $index;?>"><?php echo htmlspecialchars($job['deskripsi']); ?></h1>
                            <h1 class="display-none" id="job-status-<?php echo $index;?>"><?php echo htmlspecialchars($job['jenis_lokasi']); ?></h1>
                            <h1 class="display-none" id="job-type-<?php echo $index;?>"><?php echo htmlspecialchars($job['jenis_pekerjaan']); ?></h1>
                            <h1 class="display-none" id="job-isOpen-<?php echo $index;?>"><?php echo htmlspecialchars($job['is_open']); ?></h1>
                            <h1 class="display-none" id="job-companyid-<?php echo $index;?>"><?php echo htmlspecialchars($job['lowongan_id']); ?></h1>
                        </button>
                    <?php endforeach; ?>
                </div>
            </section>
            <section class="pagination-section">
                <?php if ($page > 1): ?>
                    <a class="pagination-prev" href="?page=<?php echo $page - 1; ?>&search=<?php echo urlencode($searchTerm); ?>&status=<?php echo urlencode($statusFilter); ?>&location=<?php echo urlencode($locationFilter); ?>">&laquo; Previous</a>
                <?php endif; ?>
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <a class="pagination-page <?php echo ($i == ($_GET['page'] ?? 1)) ? 'active' : ''; ?>" href="?page=<?php echo $i; ?>&sort=<?php echo $sort; ?>&search=<?php echo urlencode($searchTerm); ?>&status=<?php echo urlencode($statusFilter); ?>&location=<?php echo urlencode($locationFilter); ?>" <?php echo $i == $page ? 'style="font-weight: bold;"' : ''; ?>><?php echo $i; ?></a>
                <?php endfor; ?>
                <?php if ($page < $totalPages): ?>
                    <a class="pagination-next" href="?page=<?php echo $page + 1; ?>&search=<?php echo urlencode($searchTerm); ?>&status=<?php echo urlencode($statusFilter); ?>&location=<?php echo urlencode($locationFilter); ?>">Next &raquo;</a>
                <?php endif; ?>
            </section>
        </section>

        <section class="search-section">
            <form action="" method="get" id="filters-form">
                <div class="search-bar">
                    <input class="search" type="text" name="search" placeholder="Search jobs..." value="<?php echo htmlspecialchars($searchTerm); ?>">
                    <button type="submit">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <span class="sr-only">Search</span>    
                    </button>
                </div>
                <div class="filters-sort">
                    <select name="status" onchange="submitFiltersForm()">
                        <option value="">Status</option>
                        <?php foreach ($statuses as $status): ?>
                            <option value="<?php echo htmlspecialchars($status); ?>" <?php echo $status == $statusFilter ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($status === 'Open' ? 'Open' : 'Closed'); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    
                    <select name="location" onchange="submitFiltersForm()">
                        <option value="">Locations</option>
                        <?php foreach ($locations as $location): ?>
                            <option value="<?php echo htmlspecialchars($location); ?>" <?php echo $location === $locationFilter ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($location); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    
                    <select name="sort" onchange="submitFiltersForm()">
                        <option value="lowongan_id" <?php echo $sort == 'lowongan_id' ? 'selected' : ''; ?>>Sort by ID</option>
                        <option value="posisi" <?php echo $sort == 'posisi' ? 'selected' : ''; ?>>Sort by Title</option>
                        <option value="is_open" <?php echo $sort == 'is_open' ? 'selected' : ''; ?>>Sort by Status</option>
                        <option value="jenis_lokasi" <?php echo $sort == 'jenis_lokasi' ? 'selected' : ''; ?>>Sort by Location</option>
                    </select>
                </div>
            </form>
        </section>                
        <div id="modalOverlay" class="modal-overlay display-none"></div>
        <div id="myModal" class="modal display-none">
            <div class="modal-content" id="modalContent">
                <button class="close" id="close-modal">
                    <img src="../../../public/icons/close.png" class="back-logo">
                </button>
                <h1 id="modal-title" class="modal-title"></h1>
                <div class="modal-geo">
                    <h1 id="modal-company" class="modal-company"></h1>
                    <h1 id="modal-connector" class="modal-connector"> - </h1>
                    <h1 id="modal-location" class="modal-location"></h1>
                </div>
                <div class="modal-job">
                    <i class="modal-logo fa-solid fa-briefcase"></i>
                    <h1 id="modal-status" class="modal-status"></h1>
                    <h1 id="modal-type" class="modal-type"></h1>
                </div>
                <div class="modal-available">
                    <i class="fa-solid fa-tags"></i>
                    <select id="modal-select" onchange="this.form.submit()">
                        <option value="Open">Open</option>
                        <option value="Closed" >Close</option>
                    </select>
                </div>
                <h1 class="desc">Description</h1>
                <h1 id="modal-desc" class="modal-desc"></h1>
                <div class="modal-action">
                    <form class="modal-trash" id="modal-delete" action = "/detail-lowongan/delete/<?php echo $job['lowongan_id']; ?>" method="post">
                        <button  type="submit" class="btn btn-danger action-btn" onclick="return confirm('Are you sure you want to delete this job?')">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </form>
                    <a id="modal-edit" class="modal-edit">Edit</a>
                    <a id="modal-view" class="modal-view">View Applicants</a>
                </div>
            </div>
        </div>
    </main>
    <?php 
        include(__DIR__ . "/../../Components/navbar.php"); 
        generateNavbar('Company')?>
    
</body>
</html>

<script src="../../../public/js/HomeCompany.js" defer></script>