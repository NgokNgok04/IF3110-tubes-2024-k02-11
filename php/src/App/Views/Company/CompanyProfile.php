<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../public/styles/global.css">
    <link rel="stylesheet" href="../../../public/styles/navbar.css">
    <link rel="stylesheet" href="../../../public/styles/company/companyDetail.css">
    <script src="https://kit.fontawesome.com/3816d0d83d.js" crossorigin="anonymous"></script>
    <title>Company Detail</title>
</head>

<body>
    <?php
    include(__DIR__ . "/../../Components/navbar.php");
    generateNavbar('Company')
        ?>
    <form id="profile-form" class="company-profile-form" method="POST">
        <h1 class="profile-form-title">Edit Profile</h1>
        <!-- Company Name -->
        <section class="profile-form-group">
            <label for="companyName">Name</label>
            <input type="text" id="company-name" name="company_name" placeholder="Enter company name.."
                value="<?= htmlspecialchars($companyDetails['company_name']) ?>" required>
        </section>

        <!-- Company Description -->
        <section class="profile-form-group">
            <label for="aboutCompany">About</label>
            <textarea id="about" name="about" rows="4" placeholder="Enter company description.."
                required><?= htmlspecialchars($companyDetails['about']) ?></textarea>
        </section>

        <!-- Location -->
        <section class="profile-form-group">
            <label for="lokasi">Location</label>
            <input type="text" id="lokasi" name="lokasi" placeholder="Enter location.."
                value="<?= htmlspecialchars($companyDetails['lokasi']) ?>" required>
        </section>

        <!-- Submit Button -->
        <section class="profile-form-submit">
            <button type="submit" id="submitButton">Submit</button>
        </section>
    </form>

    <script src="../../../public/js/profil.js"> </script>
</body>

</html>