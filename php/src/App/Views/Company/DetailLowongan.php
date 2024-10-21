<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Details</title>

    <link rel="stylesheet" href="../../../public/styles/company/detail-lowongan.css">
</head>

<body>

    <header>
        <h1>Job Details <?= htmlspecialchars($lowongan['posisi']) ?></h1>
    </header>

    <section>
        <h2>Job Details</h2>
        <p><strong>Description:</strong> <?= htmlspecialchars($lowongan['deskripsi']) ?></p>
        <p><strong>Job Type:</strong> <?= htmlspecialchars($lowongan['jenis_pekerjaan']) ?></p>
        <p><strong>Location:</strong> <?= htmlspecialchars($lowongan['jenis_lokasi']) ?></p>
        <p><strong>Status:</strong> <?= $lowongan['is_open'] ? 'Open' : 'Closed' ?></p>

        <h2></h2>
        <table>
            <thead>
                <tr>
                    <th>Applicant Name</th>
                    <th>Status</th>
                    <th>Details</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($listLamaran)): ?>
                    <?php foreach ($listLamaran as $lamaran): ?>
                        <tr>
                            <td><?= htmlspecialchars($lamaran['nama']) ?></td>
                            <td class="status <?= strtolower($lamaran['status']) ?>">
                                <?= htmlspecialchars($lamaran['status']) ?>
                            </td>
                            <td>
                                <a href="/detail-lamaran/<?= $lamaran['lamaran_id'] ?>">Applications Details</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3">No Applications for this Job.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </section>

    <div class="action-buttons">
        <button id="deleteLowonganBtn">Delete Job</button>
        <button id="toogleLowonganBtn" data-status="<?= $lowongan['is_open'] ?>">
            <?= $lowongan['is_open'] === false ? 'Open Job' : 'Close Job' ?>
        </button>
    </div>


    <script src="../../../public/js/detail-lowongan.js"></script>
</body>

</html>