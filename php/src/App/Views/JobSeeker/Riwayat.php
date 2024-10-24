<?php
$lamaranList = $data;
$user = $user_data;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Lamaran</title>
    <link rel="stylesheet" href="../../../public/styles/global.css">
    <link rel="stylesheet" href="../../../public/styles/navbar.css">
    <script src="https://kit.fontawesome.com/3816d0d83d.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../../../public/styles/jobseeker/riwayat.css">
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
        <div class="container">
            <h1>Riwayat Lamaran</h1>
            <h2>Welcome, <strong><?php echo $user['nama'];?></strong> </h2>

            <form action="" method="get" id = 'filters-form'>
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
                                    <?php echo htmlspecialchars($status); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </form>

            
            <div class="job-listings">
                <?php foreach ($riwayatList as $lamaran): ?>
                    <div class="job-card">
                        <h2><strong><?php echo htmlspecialchars($lamaran['company_name']); ?></strong></h2>
                        <p><strong>Position:</strong> <?php echo htmlspecialchars($lamaran['posisi']); ?></p>
                        <p><strong>Location:</strong> <?php echo htmlspecialchars($lamaran['lokasi']); ?></p>
                        <p><strong>Location Type:</strong> <?php echo htmlspecialchars($lamaran['jenis_lokasi']); ?></p>
                        <p><strong>Status:</strong> <?php echo htmlspecialchars($lamaran['status']); ?></p>
                        <p><strong>Status Reason:</strong> <?php echo isset($lamaran['status_reason']) ? $lamaran['status_reason'] : '-'; ?></p>
                        <a href="/detail-lowongan/<?php echo $lamaran['lowongan_id']; ?>" class="btn">View Details</a>
                    </div>
                <?php endforeach; ?>
            </div>


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