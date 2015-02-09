<head>
    <?= $this->includeStyles() ?>
    <?= $this->includeHeadScripts() ?>
</head>
<body>
    <div class="main-layout">
        <h1>Main Layout</h1>
        <?= $page_content ?>
    </div>
    <?= $this->includeFootScripts() ?>
</body>
