<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="List of Applicant that Apply to the Job">
    <link rel="stylesheet" href="../../../public/styles/global.css">
    <link rel="stylesheet" href="../../../public/styles/navbar.css">
    <script src="https://kit.fontawesome.com/3816d0d83d.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../../../public/styles/company/detailLowongan.css">
    <title>Job Details</title>
</head>

<body>
    <?php
    include(__DIR__ . "/../../Components/navbar.php");
    generateNavbar('Company');
    ?>

    <main class="content-container">

        <div class="table-wrapper">
            <a href="/export-applicants/<?= $lowongan['lowongan_id'] ?>" class="detail-action export-button"
                aria-label="Export applicant list">Export</a>
            <table class="detail-container">
                <thead class="detail-table-head">
                    <tr>
                        <th>Name</th>
                        <th>Status</th>
                        <th>Details</th>
                    </tr>
                </thead>
                <div class="table-body-wrapper">
                    <tbody class="detail-table-body">
                        <?php if (!empty($listLamaran)): ?>
                                <?php foreach ($listLamaran as $lamaran): ?>
                                    <tr class="detail-table-row">
                                        <td class="tdata-nama"><?= htmlspecialchars($lamaran['nama']) ?></td>
                                        <td class="status <?= strtolower($lamaran['status']) ?>">
                                            <?= htmlspecialchars($lamaran['status']) ?>
                                        </td>
                                        <td>
                                            <a class="detail-action" href="/detail-lamaran/<?= $lamaran['lamaran_id'] ?>"
                                                aria-label="View details for <?= htmlspecialchars($lamaran['nama']) ?>">Detail</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3">No Applications for this Job.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </div>
            </table>
        </div>
    </main>

    <script src="../../../public/js/detail-lowongan.js"></script>
</body>

</html>