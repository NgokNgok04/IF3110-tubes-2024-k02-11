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
    <form id="updatecompany_detail" class="company-profile-form">
        <h1 class="profile-form-title">Edit Profile</h1>
        <!-- Company Name -->
        <section class="profile-form-group">
            <label for="companyName">Name</label>
            <input type="text" id="companyName" name="companyName" placeholder="Enter company name..">
        </section>

        <!-- Company Description -->
        <section class="profile-form-group">
            <label for="aboutCompany">About</label>
            <textarea id="about" name="about" rows="4" placeholder="Enter company description.."></textarea>
        </section>

        <!-- Location -->
        <section class="profile-form-group">
            <label for="lokasi">Location</label>
            <input type="text" id="lokasi" name="lokasi" placeholder="Enter location..">
        </section>

        <!-- Submit Button -->
        <section class="profile-form-submit">
            <button type="submit" id="submitButton">Submit</button>
        </section>
    </form>
</body>
<script>
    submitButton = document.getElementById("submitButton");
    submitButton.addEventListener("click", function (event) {
        event.preventDefault();
        let companyName = document.getElementById("companyName").value;
        let aboutCompany = document.getElementById("about").value;
        let location = document.getElementById("lokasi").value;

        let data = {
            companyName: companyName,
            aboutCompany: aboutCompany,
            location: location
        };

        const form = document.getElementById("updatecompany_detail");
        form.action = "/company/update";
        form.method = "POST";
        form.submit();
    });
</script>

</html>