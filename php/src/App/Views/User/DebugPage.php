<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Debug User</title>
</head>
<body>
    <form action="/debugShow" method="POST" style="margin-bottom: 10px;">
        <button type="submit">Get All User</button>
    </form>
    <form action="/debugShowLowongan" method="POST" style="margin-bottom: 10px">
        <button type="submit">Get All Lowongan</button>
    </form>
    <form action="/debugShowLamaran" method="POST" style="margin-bottom: 10px">
        <button type="submit">Get All Lamaran</button>
    </form>
    <form action="/debugShowAttachment" method="POST" style="margin-bottom: 10px">
        <button type="submit">Get All Attachment</button>
    </form>
    <form action="/debugShowCompanyDetail" method="POST" style="margin-bottom: 10px">
        <button type="submit">Get All CompanyDetail</button>
    </form>
    <form action="/delete-database" method="POST" style="margin-bottom: 10px;">
        <button type="submit">DELETE TABLE</button>
    </form>
    <form action="/create-database" method="POST" style="margin-bottom: 10px;">
        <button type="submit">CREATE TABLE</button>
    </form>
    <form action="/seeding" method="POST" style="margin-bottom: 10px;">
        <button type="submit">SEEDING</button>
    </form>

    <h2> Users </h2>
    <?php 
    if (isset($users) && !empty($users)): ?>
        <table border="1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Password</th>
                    <th>Email</th>
                    <th>Type</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($user['user_id']); ?></td>
                        <td><?php echo htmlspecialchars($user['nama']); ?></td>
                        <td><?php echo htmlspecialchars($user['password']); ?></td>
                        <td><?php echo htmlspecialchars($user['email']); ?></td>
                        <td><?php echo htmlspecialchars($user['role']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No users found.</p>
    <?php endif; ?>

    <h2> DetailLowongan </h2>
    <?php
    if(isset($lowongans) && !empty($lowongans)):?>
        <table border="1">
            <thead>
                <tr>
                    <th>lowongan_id</th>
                    <th>company_id</th>
                    <th>posisi</th>
                    <th>deskripsi</th>
                    <th>jenis_lokasi</th>
                    <th>is_open</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($lowongans as $lowongan): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($lowongan['lowongan_id']); ?></td>
                        <td><?php echo htmlspecialchars($lowongan['company_id']); ?></td>
                        <td><?php echo htmlspecialchars($lowongan['posisi']); ?></td>
                        <td><?php echo htmlspecialchars($lowongan['deskripsi']); ?></td>
                        <td><?php echo htmlspecialchars($lowongan['jenis_lokasi']); ?></td>
                        <td><?php echo htmlspecialchars($lowongan['is_open']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No lowongans found.</p>
    <?php endif; ?>


    <h2> Lamaran </h2>
    <?php
    if(isset($lamarans) && !empty($lamarans)):?>
        <table border="1">
            <thead>
                <tr>
                    <th>lamaran_id</th>
                    <th>lowongan_id</th>
                    <th>user_id</th>
                    <th>cv_path</th>
                    <th>video_path</th>
                    <th>status</th>
                    <th>status_reason</th>
                    <th>is_open</th>
                    <th>created_at</th>
                    <th>updated_at</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($lamarans as $lamaran): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($lamaran['lamaran_id'] ?? "-"); ?></td>
                        <td><?php echo htmlspecialchars($lamaran['lowongan_id'] ?? "-"); ?></td>
                        <td><?php echo htmlspecialchars($lamaran['user_id'] ?? "-"); ?></td>
                        <td><?php echo htmlspecialchars($lamaran['cv_path'] ?? "-"); ?></td>
                        <td><?php echo htmlspecialchars($lamaran['video_path'] ?? "-"); ?></td>
                        <td><?php echo htmlspecialchars($lamaran['status'] ?? "-"); ?></td>
                        <td><?php echo htmlspecialchars($lamaran['status_reason'] ?? "-"); ?></td>
                        <td><?php echo htmlspecialchars($lamaran['is_open'] ? 'Yes' : 'No'); ?></td>
                        <td><?php echo htmlspecialchars($lamaran['created_at'] ?? "-"); ?></td>
                        <td><?php echo htmlspecialchars($lamaran['updated_at'] ?? "-"); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table> 
    <?php else: ?>
        <p>No lamarans found.</p>
    <?php endif; ?>


    <h2> Attachment </h2>

    <?php
    if(isset($attachments) && !empty($attachments)):?>
        <table border="1">
            <thead>
            <tr>
                <th>attachment_id</th>
                <th>lowongan_id</th>
                <th>file_path</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($attachments as $attachment): ?>
                <tr>
                <td><?php echo htmlspecialchars($attachment['attachment_id']); ?></td>
                <td><?php echo htmlspecialchars($attachment['lowongan_id']); ?></td>
                <td><?php echo htmlspecialchars($attachment['file_path']); ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No attachments found.</p>
    <?php endif; ?>

    <h2> CompanyDetail </h2>
    <?php
    if(isset($companyDetails) && !empty($companyDetails)):?>
        <table border="1">
            <thead>
            <tr>
                <th>company_id</th>
                <th>company_name</th>
                <th>lokasi</th>
                <th>about</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($companyDetails as $companyDetail): ?>
                <tr>
                <td><?php echo htmlspecialchars($companyDetail['company_id']); ?></td>
                <td><?php echo htmlspecialchars($companyDetail['company_name']); ?></td>
                <td><?php echo htmlspecialchars($companyDetail['lokasi']); ?></td>
                <td><?php echo htmlspecialchars($companyDetail['about']); ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No companyDetails found.</p>
    <?php endif; ?>


</body>
</html>