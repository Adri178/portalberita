<?php
function site_title() {
    global $mysqli;
    $site_title = 'Berita Kita';

    // Mendapatkan URL dan memisahkan jalur dan query
    $url = $_SERVER['REQUEST_URI'];
    $parsed_url = parse_url($url);
    $path = $parsed_url['path'];
    $path_segments = explode("/", $path);

    // Mendapatkan nama halaman
    $page = end($path_segments);

    // Default title
    $site_subtitle = 'Halaman Tidak Ditemukan';
    $title = $site_subtitle . " | " . $site_title;

    // Jika tidak ada parameter id
    if (!isset($_GET['id'])) {
        switch ($page) {
            case '':
            case 'index.php':
                $site_subtitle = 'Sumber berita terpercaya';
                break;
            case 'about.php':
                $site_subtitle = 'Tentang Berita Kita';
                break;
            case 'contact.php':
                $site_subtitle = 'Kontak Kami';
                break;
            case 'buku-tamu.php':
                $site_subtitle = 'Buku Tamu';
                break;
            default:
                $site_subtitle = 'Halaman Tidak Ditemukan';
                break;
        }
        $title = $site_subtitle . " | " . $site_title;
    } else {
        $id = $_GET['id'];

        switch ($page) {
            case 'kategori.php':
                $sql = "SELECT kategori FROM kategori WHERE id_kategori='" . $id . "'";
                $qry = $mysqli->query($sql) or die($mysqli->error);
                if ($qry->num_rows > 0) {
                    $data = $qry->fetch_assoc();
                    $site_subtitle = $data['kategori'];
                } else {
                    $site_subtitle = 'Kategori Tidak Ditemukan';
                }
                break;
            case 'detail.php':
                $sql = "SELECT judul FROM berita WHERE id_berita='" . $id . "'";
                $qry = $mysqli->query($sql) or die("Error di title berita:" . $mysqli->error);
                if ($qry->num_rows > 0) {
                    $data = $qry->fetch_assoc();
                    $site_subtitle = $data['judul'];
                } else {
                    $site_subtitle = 'Berita Tidak Ditemukan';
                }
                break;
            case 'author.php':
                $sql = "SELECT auser FROM admin WHERE aid='" . $id . "'";
                $qry = $mysqli->query($sql) or die("Error di title kategori:" . $mysqli->error);
                if ($qry->num_rows > 0) {
                    $data = $qry->fetch_assoc();
                    $site_subtitle = "Berita oleh " . $data['auser'];
                } else {
                    $site_subtitle = 'Author Tidak Ditemukan';
                }
                break;
            default:
                $site_subtitle = 'Halaman Tidak Ditemukan';
                break;
        }
        $title = $site_subtitle . " | " . $site_title;
    }

    if (isset($_GET['q'])) {
        $q = $_GET['q'];
        $site_subtitle = 'Search: ' . $q;
        $title = $site_subtitle . " | " . $site_title;
    }

    return $title;
}
?>
