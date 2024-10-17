<?php

echo $_SESSION['role'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Job Seeker Home</title>
  <link rel="stylesheet" href="styles.css"> <!-- Optional: Link ke CSS -->
</head>
<body>
  <header>
    <h1>Job Listings</h1>
    <nav>
      <form method="GET" action="/search">
        <input type="text" name="query" placeholder="Cari lowongan..." />
        <button type="submit">Cari</button>
      </form>
    </nav>
  </header>

  <main>
    <section class="filters">
      <h2>Filter dan Sortir</h2>
      <form method="GET" action="/">
        <label for="location">Lokasi:</label>
        <select name="location" id="location">
          <option value="">Semua</option>
          <option value="Jakarta">Jakarta</option>
          <option value="Bandung">Bandung</option>
          <option value="Surabaya">Surabaya</option>
        </select>

        <label for="type">Jenis Pekerjaan:</label>
        <select name="type" id="type">
          <option value="">Semua</option>
          <option value="full-time">Full-Time</option>
          <option value="part-time">Part-Time</option>
          <option value="internship">Internship</option>
        </select>

        <label for="sort">Urutkan:</label>
        <select name="sort" id="sort">
          <option value="recent">Terbaru</option>
          <option value="popular">Terpopuler</option>
          <option value="salary">Gaji Tertinggi</option>
        </select>

        <button type="submit">Terapkan</button>
      </form>
    </section>

    <section class="job-listings">
      <h2>Lowongan Tersedia</h2>
      <ul>
        <li>
          <a href="/lamaran/1">
            <h3>Software Engineer</h3>
          </a>
        </li>
        <li>
          <a href="/lamaran/2">
            <h3>UI/UX Designer</h3>
          </a>
        </li>
      </ul>

      <div class="pagination">
        <a href="?page=1">&laquo; First</a>
        <a href="?page=2">Previous</a>
        <span>Page 3 of 10</span>
        <a href="?page=4">Next</a>
        <a href="?page=10">Last &raquo;</a>
      </div>
    </section>
  </main>

</body>
</html>
