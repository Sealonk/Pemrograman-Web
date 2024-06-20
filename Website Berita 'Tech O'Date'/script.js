// URL RSS feed
const rssFeedUrl = 'https://rss.app/feeds/vJcIpFqB8F4wzwAD.xml';

// Mendapatkan elemen div untuk menampilkan RSS feed
const rssContainer = document.getElementById('rss-feed');

// Mendapatkan data dari RSS feed
fetch(rssFeedUrl)
    .then(response => response.text())
    .then(xmlData => {
        // Parsing data XML
        const parser = new DOMParser();
        const xmlDoc = parser.parseFromString(xmlData, 'text/xml');
        const items = xmlDoc.querySelectorAll('item');

        // Menampilkan setiap item RSS feed
        items.forEach(item => {
            const title = item.querySelector('title').textContent;
            const link = item.querySelector('link').textContent;
            const description = item.querySelector('description').textContent;

            // Ekstrak URL gambar dari deskripsi
            const imgRegex = /<img[^>]+src="?([^"\s]+)"?[^>]*\/>/g;
            const match = imgRegex.exec(description);
            const thumbnailUrl = match ? match[1] : null;

            // Membuat elemen untuk menampilkan judul, gambar, dan link
            const feedItem = document.createElement('div');
            feedItem.classList.add('feed-item');
            const titleElement = document.createElement('h2');
            const thumbnailElement = document.createElement('img'); // Membuat elemen gambar
            const linkElement = document.createElement('a');

            // Mengatur judul, gambar, dan link
            titleElement.textContent = title;
            if (thumbnailUrl) {
                thumbnailElement.src = thumbnailUrl; // Mengatur URL gambar thumbnail
                thumbnailElement.alt = "Thumbnail";
                thumbnailElement.classList.add('thumbnail-image'); // Menambahkan kelas CSS untuk gambar
            }
            linkElement.textContent = 'Baca lebih lanjut';
            linkElement.href = link;
            linkElement.target = '_blank'; // Buka link di tab baru

            // Menambahkan elemen ke dalam div RSS feed
            feedItem.appendChild(titleElement);
            if (thumbnailUrl) {
                feedItem.appendChild(thumbnailElement); // Menambahkan elemen gambar
            }
            feedItem.appendChild(linkElement);
            rssContainer.appendChild(feedItem);
        });
    })
    .catch(error => {
        console.error('Error fetching or parsing RSS feed:', error); // Tambahkan penanganan kesalahan
    });

    // Mematikan fungsi klik kanan pada seluruh halaman web
    document.addEventListener('contextmenu', function(event) {
        event.preventDefault();
    });