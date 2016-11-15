<?php

use yii\db\Migration;

/**
 * Handles adding publish_at to table `article`.
 */
class m161115_181611_add_publish_at_column_to_article_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('article', 'publish_at', $this->timestamp());
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('article', 'publish_at');
    }
}
