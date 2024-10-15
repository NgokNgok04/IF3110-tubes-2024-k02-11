<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../public/styles/company/companyDetail.css">
    <title>Company Detail</title>
</head>
<body>
    <h1>Company Detail</h1>
    <form id="updateCompanyDetail"> 
        <!-- Company Name -->
        <section>
            <label for="companyName">Company Name:</label>
            <input type="text" id="companyName" name="companyName" placeholder="Enter company name">
        </section>

        <!-- Company Description -->
        <section>
            <label for="aboutCompany">About Company:</label>
            <textarea id="about" name="about" rows="4" placeholder="Enter company description"></textarea>
        </section>

        <!-- Location -->
        <section>
            <label for="lokasi">Location:</label>
            <input type="text" id="lokasi" name="lokasi" placeholder="Enter location">
        </section>

        <!-- Submit Button -->
        <section>
            <button type="submit" id = "submitButton">Submit</button>
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

        const form = document.getElementById("updateCompanyDetail");
        form.action = "/company/update";
        form.method = "POST";
        form.submit();
    });
</script>
</html>