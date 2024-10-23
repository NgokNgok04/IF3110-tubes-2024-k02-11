<?php
$lowonganList = $data['lowonganList'] ?? [];
$currentPage = $data['currentPage'] ?? 1;
$totalPages = $data['totalPages'] ?? 1;
// var_dump($lowonganList);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Find your dream job with our job seeker platform">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../../public/styles/global.css">
    <link rel="stylesheet" href="../../../public/styles/navbar.css">
    <link rel="stylesheet" href="../../../public/styles/login.css">
    <script src="https://kit.fontawesome.com/3816d0d83d.js" crossorigin="anonymous"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Seeker Home</title>
    <link rel="stylesheet" href="../../../public/styles/home/homejobseeker.css">
</head>
<body>
    <?php 
        include(__DIR__ . '/../../Components/navbar.php');
        if(isset($_SESSION['role']) && $_SESSION['role'] == 'jobseeker') {
            generateNavbar('JobSeeker');
        } else {
            generateNavbar('Not Login');
        }
    ?>
    <main>
        <section class="profile-section">
            <div class="profile-bg-white">
                <div class="profile-image">
                    <img src="../../../public/icons/profil.png" class="profile-icon" alt="profile-picture">
                </div>
                <h1 class="profile-name"><?php echo isset($_SESSION['name']) ? $_SESSION['name'] : 'guess'  ?></h1>
            </div>
        </section>
        <section class="list-vacancy">
            <?php if ($lowonganList): ?>
                <?php foreach ($lowonganList as $index => $lowongan): ?>
                    <button id="job-card" class="job-card">
                        <h1 class="job-title" id="job-title-<?php echo $index;?>">
                            <?php echo htmlspecialchars($lowongan['posisi']); ?>
                        </h1> 
                        <h1 class="job-company" id="job-company-<?php echo $index;?>"><?php echo htmlspecialchars($lowongan['nama']); ?></h1>
                        <div class="job-loc-type">
                            <h1 class="job-location" id="job-location-<?php echo $index;?>"><?php echo htmlspecialchars($lowongan['lokasi']); ?></h1>
                            <h1 class="job-connector"> - </h1>
                            <h1 class="job-type" id="job-type-<?php echo $index;?>"><?php echo htmlspecialchars($lowongan['jenis_pekerjaan']); ?></h1>
                        </div>
                        <h1 class="display-none" id="job-desc-<?php echo $index;?>"><?php echo htmlspecialchars($lowongan['deskripsi']); ?></h1>
                        <h1 class="display-none" id="job-status-<?php echo $index;?>"><?php echo htmlspecialchars($lowongan['jenis_lokasi']); ?></h1>
                        <h1 class="display-none" id="job-companyid-<?php echo $index;?>"><?php echo htmlspecialchars($lowongan['lowongan_id']); ?></h1>
                    </button>
                    <div id="myModal" class="modal display-none">
                        <div class="modal-content display-none" id="modalContent">
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
                            <h1 class="desc">Description</h1>
                            <h1 id="modal-desc" class="modal-desc"></h1>
                            <button class="button-apply" id="button-apply"> Melamar </button>

                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No vacancy available right now!</p>
            <?php endif; ?>
            
            <!-- 
                pagination it's not href so it can run asynchronously with search and filter (AJAX)
            -->
            <div class="pagination">
                <?php if ($currentPage > 1): ?>
                    <a class="pagination-prev" data-page="<?php echo $currentPage - 1;?>" href="javascript:void(0);">&laquo; Previous</a>
                <?php endif; ?>

                <?php for ($page = 1; $page <= $totalPages; $page++):?>
                    <a class="pagination-page <?php echo ($page == $currentPage) ? 'active' : ''; ?>" 
                    data-page="<?php echo $page; ?>" href="javascript:void(0);">
                        <?php echo $page; ?>
                    </a>
                <?php endfor; ?>

                <?php if ($currentPage < $totalPages): ?>
                    <a class="pagination-next" data-page="<?php echo $currentPage + 1; ?>" href="javascript:void(0);">Next &raquo;</a>
                <?php endif; ?>
            </div>
        </section>
        <form class="search-section" action="" method="get" id="filters-form">
            <div class="search-bar">
                <input class="search" id="searchInput" type="text" name="search" placeholder="Search jobs..." value="<?php echo htmlspecialchars($searchTerm); ?>" onkeyup="debounceSearch()">
            </div>
            <div id="location-checkboxes">
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
            <div>
                <label for="sort-by">Sort By:</label>
                <select id="sort-by" name="sort" onchange="debounceSearch()">
                    <option value="posisi" <?php echo $sort === 'posisi' ? 'selected' : ''; ?>>Position</option>
                    <option value="created_at" <?php echo $sort === 'created_at' ? 'selected' : ''; ?>>Date</option>
                    <option value="company_id" <?php echo $sort === 'company_id' ? 'selected' : ''; ?>>Company</option>
                </select>
            </div>
            </div>
        </form>
        <div id="modalOverlay" class="modal-overlay display-none"></div>
    </main>
</body>
<script src = "/../../../public/js/HomeJobseeker.js"></script>
</html>