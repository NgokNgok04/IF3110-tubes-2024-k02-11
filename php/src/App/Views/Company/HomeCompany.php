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
                    <h1 class="profile-name"><?php echo isset($companyData['nama']) ? $companyData['nama'] : 'guess' ?>
                    </h1>
                    <h1 class="profile-location">
                        <?php echo isset($companyData['lokasi']) ? $companyData['lokasi'] : 'guess location' ?>
                    </h1>
                    <h1 class="profile-about">
                        <?php echo isset($companyData['about']) ? $companyData['about'] : 'guess about' ?>
                    </h1>


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
                            <div class="display-none" id="job-desc-<?php echo $index; ?>">
                                <?= htmlspecialchars_decode($job['deskripsi']); ?>
                            </div>
                            <p>
                                <?php echo $job['jenis_lokasi']; ?>
                            </p>
                            <p>
                                <?php echo $job['jenis_pekerjaan']; ?>
                            </p>
                            <p>
                                <?php echo $job['is_open'] ? 'Open' : 'Closed'; ?>
                            </p>
                            <h1 class="display-none" id="job-status-<?php echo $index; ?>">
                                <?php echo htmlspecialchars($job['jenis_lokasi']); ?>
                            </h1>
                            <h1 class="display-none" id="job-type-<?php echo $index; ?>">
                                <?php echo htmlspecialchars($job['jenis_pekerjaan']); ?>
                            </h1>
                            <h1 class="display-none" id="job-isOpen-<?php echo $index; ?>">
                                <?php echo htmlspecialchars($job['is_open']); ?>
                            </h1>
                            <h1 class="display-none" id="job-companyid-<?php echo $index; ?>">
                                <?php echo htmlspecialchars($job['lowongan_id']); ?>
                            </h1>
                        </button>
                    <?php endforeach; ?>
                </div>
            </section>
            <!-- update pagination -->
            <div class="pagination">
                <?php if ($currentPage > 1): ?>
                    <a class="pagination-prev" data-page="<?php echo $currentPage - 1; ?>"
                        href="javascript:void(0);">&laquo;
                        Previous</a>
                <?php endif; ?>

                <?php for ($page = 1; $page <= $totalPages; $page++): ?>
                    <a class="pagination-page <?php echo ($page == $currentPage) ? 'active' : ''; ?>"
                        data-page="<?php echo $page; ?>" href="javascript:void(0);">
                        <?php echo $page; ?>
                    </a>
                <?php endfor; ?>

                <?php if ($currentPage < $totalPages): ?>
                    <a class="pagination-next" data-page="<?php echo $currentPage + 1; ?>" href="javascript:void(0);">Next
                        &raquo;</a>
                <?php endif; ?>
            </div>
        </section>

        <section class="search-section">
            <form action="" method="get" id="filters-form">
                <div class="search-bar">
                    <input class="search" id="searchInput" type="text" name="search" placeholder="Search jobs..."
                        value="<?php echo htmlspecialchars($searchTerm); ?>" onkeyup="debounceSearch()">
                </div>
                <div id="locations-checkboxes">
                    <h4>Locations</h4>
                    <label>
                        <input type="checkbox" name="locations[]" value="on-site" onchange="debounceSearch()">
                        on-site
                    </label><br>
                    <label>
                        <input type="checkbox" name="locations[]" value="hybrid" onchange="debounceSearch()">
                        hybrid
                    </label><br>
                    <label>
                        <input type="checkbox" name="locations[]" value="remote" onchange="debounceSearch()">
                        remote
                    </label><br>
                </div>
                <div id="status-checkboxes">
                    <h4>Statuses</h4>
                    <label>
                        <input type="checkbox" name="statuses[]" value="1" onchange="debounceSearch()">
                        Open
                    </label><br>
                    <label>
                        <input type="checkbox" name="statuses[]" value="0" onchange="debounceSearch()">
                        Closed
                    </label><br>
                </div>
                <div id="jobtypes-checkboxes">
                    <h4>Job Type</h4>
                    <label>
                        <input type="checkbox" name="jobtypes[]" value="full-time" onchange="debounceSearch()">
                        Full-time
                    </label><br>
                    <label>
                        <input type="checkbox" name="jobtypes[]" value="part-time" onchange="debounceSearch()">
                        Part-time
                    </label><br>
                    <label>
                        <input type="checkbox" name="jobtypes[]" value="internship" onchange="debounceSearch()">
                        Internship
                    </label><br>
                </div>
                <div>
                    <label for="sort-by">Sort By:</label>
                    <select id="sort-by" name="sort" onchange="debounceSearch()">
                        <option value="posisi" <?php echo $sort === 'posisi' ? 'selected' : ''; ?>>Position</option>
                        <option value="created_at" <?php echo $sort === 'created_at' ? 'selected' : ''; ?>>Date</option>
                        <option value="company_id" <?php echo $sort === 'company_id' ? 'selected' : ''; ?>>Company
                        </option>
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
                        <option value="Closed">Close</option>
                    </select>
                </div>
                <h1 class="desc">Description</h1>
                <div id="modal-desc" class="modal-desc"></div>
                <div class="modal-action">
                    <form class="modal-trash" id="modal-delete"
                        action="/detail-lowongan/delete/<?php echo $job['lowongan_id']; ?>" method="post">
                        <button type="submit" class="btn btn-danger action-btn"
                            onclick="return confirm('Are you sure you want to delete this job?')">
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
    generateNavbar('Company') ?>

</body>
<script src="../../../public/js/HomeCompany.js" defer></script>

</html>