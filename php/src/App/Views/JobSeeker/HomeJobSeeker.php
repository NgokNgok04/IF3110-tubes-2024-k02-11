<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
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
        generateNavbar('JobSeeker');
    ?>
    <main>
        <div class="container">
            <h1>Welcome, <?php echo $_SESSION['role'] ?? 'Job Seeker'; ?></h1>
            <h2>Available Jobs</h2>

        <form action="" method="get" id="filters-form">
            <div class="search-bar">
                <input type="text" name="search" placeholder="Search jobs..." value="<?php echo htmlspecialchars($searchTerm); ?>">
                <button type="submit">Search</button>
            </div>

            <div class="filters-sort">
                <div class="filters">
                    <select name="location" onchange="submitFiltersForm()">
                        <option value="">All Locations</option>
                        <?php foreach ($locations as $location): ?>
                            <option value="<?php echo htmlspecialchars($location); ?>" <?php echo $location === $locationFilter ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($location); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <select name="status" onchange="submitFiltersForm()">
                        <option value="">All Statuses</option>
                        <?php foreach ($statuses as $status): ?>
                            <option value="<?php echo htmlspecialchars($status); ?>" <?php echo $status == $statusFilter ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($status === 'Open' ? 'Open' : 'Closed'); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>


                <div class="sort">
                    <label for="sort-by">Sort by:</label>
                    <select id="sort-by" name="sort" onchange="submitFiltersForm()">
                        <option value="posisi" <?php echo $sort === 'posisi' ? 'selected' : ''; ?>>Relevance</option>
                        <option value="lowongan_id" <?php echo $sort === 'lowongan_id' ? 'selected' : ''; ?>>Date</option>
                        <option value="company_id" <?php echo $sort === 'company_id' ? 'selected' : ''; ?>>Company</option>
                    </select>
                </div>
            </div>
        </form>


            <?php if ($lowonganList): ?>
                <div class="job-listings">
                    <?php foreach ($lowonganList as $lowongan): ?>
                        <div class="job-card">
                            <h3><?php echo htmlspecialchars($lowongan['posisi']); ?></h3>
                            <p><strong>Company:</strong> <?php echo htmlspecialchars($lowongan['company_id']); ?></p>
                            <p><strong>Description: </strong><?php echo htmlspecialchars($lowongan['deskripsi']); ?></p>
                            <p><strong>Job Type:</strong> <?php echo htmlspecialchars($lowongan['jenis_pekerjaan']); ?></p>
                            <p><strong>Location:</strong> <?php echo htmlspecialchars($lowongan['jenis_lokasi']); ?></p>
                            <p><strong>Status:</strong> <?php echo $lowongan['is_open'] === 'Open' ? 'Open' : 'Closed'; ?></p>
                            <a href="/detail-lowongan/<?php echo $lowongan['lowongan_id']; ?>" class="btn">View Details</a>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p>No jobs available at the moment.</p>
            <?php endif; ?>

            <div class="pagination">
                <?php if ($currentPage > 1): ?>
                    <a href="?page=<?php echo $currentPage - 1; ?>&sort=<?php echo $sort; ?>&search=<?php echo urlencode($searchTerm); ?>&location=<?php echo urlencode($locationFilter); ?>">&laquo; Previous</a>
                <?php endif; ?>

                <?php for ($page = 1; $page <= $totalPages; $page++): ?>
                    <a href="?page=<?php echo $page; ?>&sort=<?php echo $sort; ?>&search=<?php echo urlencode($searchTerm); ?>&location=<?php echo urlencode($locationFilter); ?>" <?php echo $page == $currentPage ? 'class="active"' : ''; ?>>
                        <?php echo $page; ?>
                    </a>
                <?php endfor; ?>

                <?php if ($currentPage < $totalPages): ?>
                    <a href="?page=<?php echo $currentPage + 1; ?>&sort=<?php echo $sort; ?>&search=<?php echo urlencode($searchTerm); ?>&location=<?php echo urlencode($locationFilter); ?>">Next &raquo;</a>
                <?php endif; ?>
            </div>
        </div>
    </main>
</body>
<script> 
    function submitFiltersForm() {
        document.getElementById('filters-form').submit();
    }
</script>
</html>