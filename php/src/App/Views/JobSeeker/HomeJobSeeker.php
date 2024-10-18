<?php
//not dummy anymore
$lowonganList = $data['lowonganList'] ?? [];
// Dummy data generation
// for ($i = 1; $i <= 30; $i++) {
//     $lowonganList[] = [
//         'posisi' => 'Job Position ' . $i,
//         'company_id' => 'Company ' . chr(64 + $i % 5), // A, B, C, D, E
//         'deskripsi' => 'Description for job position ' . $i,
//         'jenis_pekerjaan' => ($i % 2 == 0) ? 'Full-time' : 'Part-time',
//         'jenis_lokasi' => ($i % 3 == 0) ? 'Remote' : 'On-site',
//         'is_open' => ($i % 4 == 0) // Open every 4th job
//     ];
// }


// Pagination 
$itemsPerPage = 10;
$totalItems = count($lowonganList);
$totalPages = ceil($totalItems / $itemsPerPage);
$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;

if ($currentPage < 1) {
    $currentPage = 1;
} elseif ($currentPage > $totalPages) {
    $currentPage = $totalPages;
}

$offset = ($currentPage - 1) * $itemsPerPage;
$currentItems = array_slice($lowonganList, $offset, $itemsPerPage);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Seeker Home</title>
    <link rel="stylesheet" href="../../../public/styles/home/homejobseeker.css">
</head>
<body>

    <main>
        <h1>Welcome, <?php echo $_SESSION['user_name'] ?? 'Job Seeker'; ?></h1>
        <div class="container">
            <h2>Available Job</h2>
            <?php if ($currentItems): ?>
                <div class="job-listings">
                    <?php foreach ($currentItems as $lowongan): ?>
                        <div class="job-card">
                            <h3><?php echo htmlspecialchars($lowongan['posisi']); ?></h3>
                            <p><strong>Company:</strong> <?php echo htmlspecialchars($lowongan['company_id']); ?></p>
                            <p><strong>Description: </strong><?php echo htmlspecialchars($lowongan['deskripsi']); ?></p>
                            <p><strong>Job Type:</strong> <?php echo htmlspecialchars($lowongan['jenis_pekerjaan']); ?></p>
                            <p><strong>Location:</strong> <?php echo htmlspecialchars($lowongan['jenis_lokasi']); ?></p>
                            <p><strong>Open:</strong> <?php echo $lowongan['is_open'] ? 'Yes' : 'No'; ?></p>
                            <a href="/detail-lowongan/<?php echo $lowongan['lowongan_id']; ?>"  method="GET" class="btn">Apply Now</a>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p>No job available at the moment.</p>
            <?php endif; ?>

            <!-- Pagination -->
            <div class="pagination">
                <?php if ($currentPage > 1): ?>
                    <a href="?page=<?php echo $currentPage - 1; ?>">&laquo; Previous</a>
                <?php endif; ?>
                
                <?php for ($page = 1; $page <= $totalPages; $page++): ?>
                    <a href="?page=<?php echo $page; ?>" <?php echo ($page == $currentPage) ? 'class="active"' : ''; ?>>
                        <?php echo $page; ?>
                    </a>
                <?php endfor; ?>
                <?php if ($currentPage < $totalPages): ?>
                    <a href="?page=<?php echo $currentPage + 1; ?>">Next &raquo;</a>
                <?php endif; ?>
            </div>
        </div>
    </main>

</body>
</html>
