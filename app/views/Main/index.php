<div class="container">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Категории:</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <?php if (!empty ($menu)): ?>
                    <?php foreach ($menu as $item): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="#"><?= $item['title'] ?></a>
                        </li>
                    <?php endforeach; ?>
                <?php endif; ?>
            </ul>
        </div>
    </nav>
</div>

<div class="container">
    <?php if (!empty ($postsAll)): ?>
        <?php foreach ($postsAll as $post): ?>
            <h1><?= $post['title'] ?></h1>
            <p><?= $post['text'] ?></p>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
