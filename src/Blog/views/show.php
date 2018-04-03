<?= ($renderer->render(('header'), ['title'=>$slug])); ?>

<h1><?=ucfirst($slug) . ' ' . $id?></h1>
<p><a class="btn btn-primary" href="/blog" role="button">Home</a></p>


<?= ($renderer->render('footer')); ?>
