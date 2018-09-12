<?php

use yii\db\Migration;

/**
 * Handles adding view_column to table `article_table`.
 */
class m180912_154337_add_seo_text_column_to_article_translation_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        if ($this->getDb()->getTableSchema('article_translation')) {
            $this->addColumn('article_translation', 'seo_text', $this->text());
        }
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        if ($this->getDb()->getTableSchema('article_translation')) {
            $this->dropColumn('article_translation', 'seo_text');
        }
    }
}
