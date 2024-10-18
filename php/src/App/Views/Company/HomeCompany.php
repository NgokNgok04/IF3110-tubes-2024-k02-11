<?php
// Get job listings from the controller
$jobs = $data['jobs'];

// Get unique statuses and locations for filters
$statuses = array_unique(array_column($jobs, 'is_open'));
$locations = array_unique(array_column($jobs, 'jenis_lokasi'));


// var_dump($statuses);
// Sorting
$sort = $_GET['sort'] ?? 'lowongan_id';
usort($jobs, function($a, $b) use ($sort) {
    return $a[$sort] <=> $b[$sort];
});

// Filtering
$statusFilter = $_GET['status'] ?? '';
$locationFilter = $_GET['location'] ?? '';
$searchTerm = $_GET['search'] ?? '';

if (!empty($statusFilter) || !empty($locationFilter) || !empty($searchTerm)) {
    $jobs = array_filter($jobs, function($job) use ($statusFilter, $locationFilter, $searchTerm) {
        $matchesStatus = empty($statusFilter) || $job['is_open'] == $statusFilter;
        $matchesLocation = empty($locationFilter) || $job['jenis_lokasi'] == $locationFilter;
        $matchesSearch = empty($searchTerm) || stripos($job['posisi'], $searchTerm) !== false || stripos($job['deskripsi'], $searchTerm) !== false;
        return $matchesStatus && $matchesLocation && $matchesSearch;
    });
}

// Pagination
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$perPage = 5;
$totalJobs = count($jobs);
$totalPages = ceil($totalJobs / $perPage);
$jobs = array_slice($jobs, ($page - 1) * $perPage, $perPage);

// Handle job deletion and status update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    ///TODO
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Job</title>
    <link rel="stylesheet" href="../../../public/styles/home/homecompany.css">
</head>
<body>
    <div class="container">
        <h1>Job List</h1>
        <form action="" method="get">
            <div class="filters">
                <input type="text" name="search" placeholder="Search jobs..." value="<?php echo htmlspecialchars($searchTerm); ?>">
                
                <select name="status">
                    <option value="">All Statuses</option>
                    <?php foreach ($statuses as $status): ?>
                        <option value="<?php echo htmlspecialchars($status); ?>" <?php echo $status == $statusFilter ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($status === 'Open' ? 'Open' : 'Closed'); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                
                <select name="location">
                    <option value="">All Locations</option>
                    <?php foreach ($locations as $location): ?>
                        <option value="<?php echo htmlspecialchars($location); ?>" <?php echo $location === $locationFilter ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($location); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                
                <select name="sort">
                    <option value="lowongan_id" <?php echo $sort == 'lowongan_id' ? 'selected' : ''; ?>>Sort by ID</option>
                    <option value="posisi" <?php echo $sort == 'posisi' ? 'selected' : ''; ?>>Sort by Title</option>
                    <option value="is_open" <?php echo $sort == 'is_open' ? 'selected' : ''; ?>>Sort by Status</option>
                    <option value="jenis_lokasi" <?php echo $sort == 'jenis_lokasi' ? 'selected' : ''; ?>>Sort by Location</option>
                </select>
                
                <button type="submit" class="btn">Apply Filters</button>
            </div>
        </form>

        <a href="/[something]" class="btn">Add New Job</a>

        <table>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Description</th>
                <th>Status</th>
                <th>Location</th>
                <th>Actions</th>
            </tr>
            <?php foreach ($jobs as $job): ?>
            <tr>
                <td><?php echo htmlspecialchars($job['lowongan_id']); ?></td>
                <td><?php echo htmlspecialchars($job['posisi']); ?></td>
                <td><?php echo htmlspecialchars($job['deskripsi']); ?></td>
                <td><?php echo htmlspecialchars($job['is_open'] === 'Open' ? 'Open' : 'Closed'); ?></td>
                <td><?php echo htmlspecialchars($job['jenis_lokasi']); ?></td>
                <td>
                    <div class="action-buttons">
                        <a href="/[something]/<?php echo $job['lowongan_id']; ?>" class="btn action-btn">View Applicants</a>
                        <a href="/[something]/<?php echo $job['lowongan_id']; ?>" class="btn action-btn">Edit</a>
                        <form method="post">
                            <input type="hidden" name="delete" value="<?php echo $job['lowongan_id']; ?>">
                            <button type="submit" class="btn btn-danger action-btn" onclick="return confirm('Are you sure you want to delete this job?')">Delete</button>
                        </form>
                        <form method="post">
                            <input type="hidden" name="update_status" value="<?php echo $job['lowongan_id']; ?>">
                            <select name="new_status" onchange="this.form.submit()" class="status-select">
                                <option value="Open" <?php echo $job['is_open'] ? 'selected' : ''; ?>>Open</option>
                                <option value="Closed" <?php echo !$job['is_open'] ? 'selected' : ''; ?>>Closed</option>
                            </select>
                        </form>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>

        <div class="pagination">
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <a href="?page=<?php echo $i; ?>&sort=<?php echo $sort; ?>&search=<?php echo urlencode($searchTerm); ?>&status=<?php echo urlencode($statusFilter); ?>&location=<?php echo urlencode($locationFilter); ?>" <?php echo $i == $page ? 'style="font-weight: bold;"' : ''; ?>><?php echo $i; ?></a>
            <?php endfor; ?>
        </div>
    </div>
</body>
</html>