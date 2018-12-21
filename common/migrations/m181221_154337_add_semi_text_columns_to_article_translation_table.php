<?php

use yii\db\Migration;

/**
 * Handles adding view_column to table `article_table`.
 */
class m181221_154337_add_semi_text_columns_to_article_translation_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        if ($this->getDb()->getTableSchema('article_translation')) {
            $this->addColumn('article_translation', 'menu_title', $this->string());
            $this->addColumn('article_translation', 'short_title', $this->string());
            $this->addColumn('article_translation', 'semi_text', $this->text());
        }
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        if ($this->getDb()->getTableSchema('article_translation')) {
            $this->dropColumn('article_translation', 'menu_title');
            $this->dropColumn('article_translation', 'short_title');
            $this->dropColumn('article_translation', 'semi_text');
        }
    }
}
