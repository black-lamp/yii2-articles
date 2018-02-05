<?php
use bl\articles\common\entities\Article;
use frontend\assets\CarouselAsset;
use yii\helpers\Url;
use yii\web\View;

/**
 * @author Gutsulyak Vadim <guts.vadim@gmail.com>
 * @var View $this
 * @var Article[] $articles
 * @var string $title
 * @var boolean $slider
 */
?>

<?php if (!empty($articles)): ?>
    <?php if (!empty($slider)): ?>
        <section class="articles-slider">
            <div class="container">
                <?php if (!empty($title)): ?>
                    <div class="sub-title text-center">
                        <?= $title ?>
                    </div>
                <?php endif; ?>

                <div id="articles-carousel" class="carousel slide" data-ride="carousel">
                    <!-- Indicators -->
                    <ol class="carousel-indicators">
                        <?php for ($i = 0; $i < count($articles); $i+=2): ?>
                            <li data-target="#articles-carousel" data-slide-to="<?= $i ?>"
                                class="<?= $i == 0 ? 'active' : '' ?>"></li>
                        <?php endfor; ?>
                    </ol>

                    <!-- Wrapper for slides -->
                    <div class="carousel-inner">
                        <?php for ($i = 0; $i < count($articles); $i+=2): ?>
                            <div class="item <?= $i == 0 ? 'active' : '' ?>">
                                <?php if(!empty($articles[$i])): ?>
                                    <div class="col-md-6">
                                        <?= $this->render('article-mini', [
                                            'article' => $articles[$i]
                                        ]) ?>
                                    </div>
                                <?php endif; ?>
                                <?php if(!empty($articles[$i+1])): ?>
                                    <div class="col-md-6">
                                        <?= $this->render('article-mini', [
                                            'article' => $articles[$i+1]
                                        ]) ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endfor; ?>
                    </div>

                    <!-- Controls -->
                    <a class="left carousel-control" href="#articles-carousel" data-slide="prev">
                        <i class="icon icon-arrow-left"></i>
                    </a>
                    <a class="right carousel-control" href="#articles-carousel" data-slide="next">
                        <i class="icon icon-arrow-right"></i>
                    </a>
                </div>

            </div>
        </section>
        <hr>
    <?php else: ?>
        <div class="row">
            <?php foreach ($articles as $article): ?>
                <div class="col-md-6">
                    <?= $this->render('article-mini', [
                        'article' => $article
                    ]) ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
<?php endif; ?>
