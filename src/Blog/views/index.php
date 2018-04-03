<?= ($renderer->render('header')); ?>

<h1>Hello world</h1>

<ul>
    <li><a href="<?= $router->generateUri('blog.show', [ 'slug' => 'article', 'id'=>'1']);?>">Article 1</a></li>
    <li><a href="<?= $router->generateUri('blog.show', [ 'slug' => 'article', 'id'=>'2']);?>">Article 2</a></li>
    <li><a href="<?= $router->generateUri('blog.show', [ 'slug' => 'article', 'id'=>'3']);?>">Article 3</a></li>
    <li><a href="<?= $router->generateUri('blog.show', [ 'slug' => 'article', 'id'=>'4']);?>">Article 4</a></li>
</ul>
<?= ($renderer->render('footer')); ?>
