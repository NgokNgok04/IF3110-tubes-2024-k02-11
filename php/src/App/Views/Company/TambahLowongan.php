<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Lowongan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    
    <!-- Quill.js CSS -->
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

    <style>
        body {
            background-color: #f3f2ef;
        }

        .navbar {
            background-color: #0a66c2;
        }

        .navbar-brand {
            color: white;
            font-weight: bold;
        }

        .container {
            margin-top: 50px;
            max-width: 800px;
        }

        .card {
            padding: 30px;
            border-radius: 10px;
        }

        .form-label {
            font-weight: bold;
        }

        #description-container {
            height: 300px;
            margin-bottom: 20px;
        }

        #requirement-container{
            height: 200px;
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #0a66c2;
            border: none;
        }

        .btn-primary:hover {
            background-color: #004182;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="card shadow">
            <h3 class="text-center mb-4">Tambah Lowongan</h3>
            <form action="/tambah-lowongan/add" method="post" onsubmit="return submitForm()">
                <div class="mb-3">
                    <label for="title" class="form-label">Job Title</label>
                    <input type="text" class="form-control" id="title" name="title" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Job Description</label>
                    <div id="description-container"></div>
                    <input type="hidden" name="description" id="description">
                </div>

                <div class="mb-3">
                    <label for="requirements" class="form-label">Requirements</label>
                    <div id="requirement-container"></div>
                    <input type="hidden" name="requirements" id="requirements">
                </div>

                <div class="mb-3">
                    <label for="location" class="form-label">Location</label>
                    <select class="form-control" id="location" name="location" required>
                        <option value="">Select Type Location</option>
                        <option value="on-site">On-site</option>
                        <option value="hybrid">Hybrid</option>
                        <option value="remote">Remote</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary w-100">Post Job</button>
            </form>
        </div>
    </div>

    <!-- Quill.js JS -->
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    <script>
        // Initialize Quill editor
        const quill = new Quill('#description-container', {
            theme: 'snow',
            placeholder: 'Enter job description...',
            modules: {
                toolbar: [
                    [{ header: [1, 2, 3, false] }],
                    ['bold', 'italic', 'underline'],
                    ['link', 'blockquote', 'code-block'],
                    [{ list: 'ordered' }, { list: 'bullet' }]
                ]
            }
        });

        const quillReq = new Quill('#requirement-container', {
            theme: 'snow',
            placeholder: 'Enter job requirements...',
            modules: {
                toolbar: [
                    [{ header: [1, 2, 3, false] }],
                    ['bold', 'italic', 'underline'],
                    ['link', 'blockquote', 'code-block'],
                    [{ list: 'ordered' }, { list: 'bullet' }]
                ]
            }
        });

        // Submit handler to get Quill content as HTML
        function submitForm() {
            const descriptionHTML = quill.root.innerHTML;
            document.getElementById('description').value = descriptionHTML;
            const requirementsHTML = quillReq.root.innerHTML;
            document.getElementById('requirements').value = requirementsHTML;
            return true;
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
