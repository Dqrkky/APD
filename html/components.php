<?php
require_once "core.php";

function Card($title, $body) {
    return h('div', ['className' => 'card mb-3'],
        h('div', ['className' => 'card-body'],
            h('h5', ['className' => 'card-title'], htmlspecialchars($title)),
            h('p', ['className' => 'card-text'], htmlspecialchars($body))
        )
    );
}

function fetchPosts() {
    list($posts, $setPosts) = useState('posts', null);
    // cache in session (acts like useEffect [])
    if (!isset($posts)) {
        $json = @file_get_contents("https://jsonplaceholder.typicode.com/posts?_limit=5");
        if ($json === false) {
            $setPosts([
                ['title' => 'Error', 'body' => 'Failed to fetch posts']
            ]);
        }
        $data = json_decode($json, true);
        if (!is_array($data)) {
            $setPosts([
                ['title' => 'Error', 'body' => 'Invalid API response']
            ]);
        }
        $setPosts($data);
    }

    return $_SESSION['posts'];
}

function Home() {
    $posts = fetchPosts();
    $cards = array_map(function($p) {
        return Card($p['title'] ?? '', $p['body'] ?? '');
    }, $posts);
    return h('div', [],
        h('h2', [], 'Home Page'),
        implode("", $cards)
    );
}

function About() {
    return h('div', [],
        h('h2', [], 'About Page'),
        h('p', [], 'PHP version of mini React')
    );
}

function VideoPage() {
    return h('div', [],
        h('h2', [], 'Video Player'),
        h('div', ['className' => 'card p-3'],
            h('video', [
                'src' => 'https://www.w3schools.com/html/mov_bbb.mp4',
                'poster' => 'https://peach.blender.org/wp-content/uploads/title_anouncement.jpg?x11217',
                'controls' => 'true',
                'style' => 'width:100%; border-radius:6px;'
            ])
        )
    );
}

function application_ld_json($data) {
    return h('script', [
        'type' => 'application/ld+json'
    ],
    json_encode($data)
    );
}