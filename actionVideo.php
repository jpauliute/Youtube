<?php
$vid = isset($_GET['vid']) ? $_GET['vid'] : '';

$video = S::fetch('*', 'videos', 'vid=:vid', [':vid' => $vid]);
$categoryName = S::fetchColumn('name', 'categories', 'id=:id', [':id' => $video['category']]);

$videos = S::fetchAll(
    'SELECT * FROM videos WHERE category=:id AND vid!=:vid ORDER BY views DESC LIMIT 20',
    [
        ':id' => $video['category'],
        ':vid' => $vid
    ]
);
?>

<div class="row mt-5">
    <div class="col col-10">
        <a href="?pg=" class="btn btn-danger mb-4">Back to list</a>
        <iframe src="https://www.youtube.com/embed/<?= $vid ?>?autoplay=0"></iframe>
        <h4 class="d-inline">
            <?= $video['name'] ?>
        </h4>
        <div class="d-block mt-2">
            <sup>
                <?= getUserNickById($video['uid']) ?>
            </sup>
            <sup class="text-muted">
                <?= $video['views'] + 1 ?> views
            </sup>
        </div>
        <p class="text-muted">
            <?= $video['description'] ?>
        </p>
    </div>

</div>